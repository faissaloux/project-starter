<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPtricks\Orm\Database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Noodlehaus\Config;
use \App\Models\User;
use Slim\Flash\Messages as Flash;


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
$capsule->addConnection([
    'driver'    => $container['conf']['db.driver'],
    'host'      => $container['conf']['db.host'],
    'database'  => $container['conf']['db.name'],
    'username'  => $container['conf']['db.username'],
    'password'  => $container['conf']['db.password'],
    'charset'   => $container['conf']['db.charset'],
    'collation' => $container['conf']['db.collation'],
    'prefix'    => '',
    'strict' => false
]);


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

foreach (new DirectoryIterator(BASEPATH.'/App/Controllers/') as $file) {
  if ($file->isFile() and ($file->getFilename() != 'index.php' and $file->getFilename() !=  'settingsController.php')) {
      $key = str_replace("Controller.php", "", $file->getFilename());
      $controller = "\\App\\Controllers\\{$key}Controller";
      $container[$key] = new $controller($container);
  }
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

// Setup 404 Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        global $container;
        return $container->view->render($response->withStatus(404),'website/404.twig');
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
    

    
    
  
    
    $filter = new Twig_SimpleFilter('options', function ($username) {
        $options = new App\Models\Options();
        $option = $options->get_option($username);
        if($option){
            return $option;
        }else {
              return "";
        }
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('dateOnly', function ($username) {
        $date = date('Y-m-d', strtotime($username));
        if(date('Y-m-d') == date('Y-m-d', strtotime($date))) {
             return "اليوم";
        }
        
        return $date;
    });
    $view->getEnvironment()->addFilter($filter);
  
  
    $filter = new Twig_SimpleFilter('highlight_code', function ($username) {
        
        $helper = new helper();
        return $helper->highlight_code($username);
        
    });
    $view->getEnvironment()->addFilter($filter);
      
    
    
    
   $filter = new Twig_SimpleFilter('file_size', function ($file) {
       global $container;
       $helper= new Helper();
       $file = $container->conf['dir.media'].$file;
       if(file_exists($file)){
         echo $helper->calc(filesize($file));
       }
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
$container['twitter'] = $container['conf']['twitter'];
$container['auth'] = new \App\Helpers\Auth\auth;




/************************************************************************/
/********************** ADD VIEWS TO CONTAINER   ************************/
/************************************************************************/
$search = $_GET['search'] ?? '';
$cart = $_SESSION['CART'] ?? [];

$container['view']->getEnvironment()->addGlobal('admin_assets', $container['conf']['url.admin_assets']);
$container['view']->getEnvironment()->addGlobal('website_assets', $container['conf']['url.website_assets']);
$container['view']->getEnvironment()->addGlobal('search', $search);
$container['view']->getEnvironment()->addGlobal('assets', $container['conf']['url.assets']);
$container['view']->getEnvironment()->addGlobal('ads_url', $container['conf']['url.ads']); 
$container['view']->getEnvironment()->addGlobal('config', $container['conf']['app']); 
$container['view']->getEnvironment()->addGlobal('url', $container['conf']['url']); 
$container['view']->getEnvironment()->addGlobal('dir', $container['conf']['dir']); 
//$container['view']->getEnvironment()->addGlobal('searchCategories', ProductCategories::all()); 
//$container['view']->getEnvironment()->addGlobal('menus', Menus::All()); 
$container['view']->getEnvironment()->addGlobal('cart', $cart); 

if(isset($_SESSION['auth-admin'])) {   
    $container['view']->getEnvironment()->addGlobal('admin',$capsule->table('users')->find($_SESSION['auth-admin']) );
}
if(isset($_SESSION['auth-user'])) {   
    $container['view']->getEnvironment()->addGlobal('user',$capsule->table('users')->find($_SESSION['auth-user']) );
}





































// Language System

if(isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $file = BASEPATH.'/app/lang/admin/'.$_SESSION['lang'].'.php';
    $container['view']->getEnvironment()->addGlobal('l', Config::load($file));
    $_SESSION['l'] = include ($file);
}

    

if(!isset($_GET['lang'])){
    if(!isset($_SESSION['lang'])){   
        $_SESSION['lang'] = "en";
        $file = BASEPATH.'/app/lang/admin/en.php';
        $container['view']->getEnvironment()->addGlobal('l', Config::load($file));
        $_SESSION['l'] = include ($file);
        
        // countries
        $container['l'] = Config::load($file);
        
        
    }else{
        $file = BASEPATH.'/app/lang/admin/'.$_SESSION['lang'].'.php';
        $container['view']->getEnvironment()->addGlobal('l', Config::load($file));
        
        // countries
        
        $container['l'] = Config::load($file);
        
        $_SESSION['l'] = include ($file);
    }
}




