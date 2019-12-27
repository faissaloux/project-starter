<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPtricks\Orm\Database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Noodlehaus\Config;
use \App\Models\User;
use Slim\Flash\Messages as Flash;


ini_set("display_errors", 1);
ini_set('log_errors', 1);
error_reporting(1);
@ini_set('display_errors',1);



// Set the container
$container = $app->getContainer();

// Get All the settings From Config File
$container['conf'] = function () {
    return Config::load(INC_ROOT.'/app/config.php');
};



/***************************************************************/
/************************ CONNECT TO DATABASE ******************/
/***************************************************************/
// Connect To DataBase
$capsule = new Capsule;
if($container['conf']['app.debug']) {
      $capsule->addConnection([
            'driver'    => $container['conf']['db_sandbox.driver'],
            'host'      => $container['conf']['db_sandbox.host'],
            'database'  => $container['conf']['db_sandbox.name'],
            'username'  => $container['conf']['db_sandbox.username'],
            'password'  => $container['conf']['db_sandbox.password'],
            'charset'   => $container['conf']['db_sandbox.charset'],
            'collation' => $container['conf']['db_sandbox.collation'],
            'prefix'    => '',
            'strict' => false
        ]);
}else {
          $capsule->addConnection([
            'driver'    => $container['conf']['db_live.driver'],
            'host'      => $container['conf']['db_live.host'],
            'database'  => $container['conf']['db_live.name'],
            'username'  => $container['conf']['db_live.username'],
            'password'  => $container['conf']['db_live.password'],
            'charset'   => $container['conf']['db_live.charset'],
            'collation' => $container['conf']['db_live.collation'],
            'prefix'    => '',
            'strict' => false
        ]);
}
  



// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

try {
    Capsule::connection()->getPdo();
} catch (\Exception $e) {
    die("Could not connect to the database.  Please check your configuration. "  );
}




/************************************************************************/
/************************ ADD CONTROLLERS TO CONTAINER ******************/
/************************************************************************/

$path = BASEPATH.'/App/Controllers/';

if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        if ('index.php' === $file) continue;
        
            if($key != 'settings') {
                $key = str_replace("Controller.php", "", $file);
                $controller = "\\App\\Controllers\\{$key}Controller";
                $container[$key] = new $controller($container);

            }
    }
    closedir($handle);
}












/************************************************************************/
/******************** ERROR PAGES AND CODE HANDLING *********************/
/************************************************************************/
// 405 Error Handler
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $response->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write(' ');
    };
};


//  Stop the errors when the mode is live
if($container['conf']['app.debug'] == false ):  
    ini_set("display_errors", 0);
    ini_set('log_errors', 0);
    error_reporting(0);
    @ini_set('display_errors',0);
endif;


// Register Flash Messages
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};


// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../app/Views', [
        'cache' => false,
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
        
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
    new Slim\Flash\Messages()
    ));
    $view->getEnvironment()->addglobal('flash',$c->flash);
    
    
    $filter = new Twig_SimpleFilter('dateOnly', function ($username) {
        $date = date('Y-m-d', strtotime($username));
        if(date('Y-m-d') == date('Y-m-d', strtotime($date))) {
             return "اليوم";
        }
        return $date;
    });
    $view->getEnvironment()->addFilter($filter);
  

    $filter = new Twig_SimpleFilter('st', function ($username) {
        return st($username);
    });
    $view->getEnvironment()->addFilter($filter);
    
   
    
    return $view;
};




/************************************************************************/
/******************** ADD CLASSES TO CONTAINER   ************************/
/************************************************************************/
$container['db'] = $capsule;
$container['auth'] = new \App\Helpers\Auth();




/************************************************************************/
/********************** ADD VIEWS TO CONTAINER   ************************/
/************************************************************************/
$container['view']->getEnvironment()->addGlobal('admin_assets', $container['conf']['url.admin_assets']);
$container['view']->getEnvironment()->addGlobal('assets', $container['conf']['url.assets']);
$container['view']->getEnvironment()->addGlobal('config', $container['conf']['app']); 
$container['view']->getEnvironment()->addGlobal('url', $container['conf']['url']); 
$container['view']->getEnvironment()->addGlobal('dir', $container['conf']['dir']); 




/************************************************************************/
/********************** set auth   *************************************/
/************************************************************************/
if(isset($_SESSION['auth'])) {   
    $container['view']->getEnvironment()->addGlobal('admin',$capsule->table('users')->find($_SESSION['auth']) );
}



/************************************************************************/
/********************** Language System  ********************************/
/************************************************************************/
$file = BASEPATH.'/app/Lang/admin/fr.php';
$container['view']->getEnvironment()->addGlobal('l', Config::load($file));
$_SESSION['l'] = include($file);













    