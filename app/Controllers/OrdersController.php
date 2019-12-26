<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Order;
use \App\Models\Cart;
use \App\Models\Product;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use \App\Classes\Cart as Basket;


defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends Controller {
    
    
        
    public $route = [ 'index' => 'coupons' , 'create' => 'coupons.create'  ];
    public $model = 'Order';
    public $folder = 'orders';
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',
        'cloned'            => 'copoun code has been duplicated successfully',
        'NotValid'          => 'coupon code is not valid or expired',
        'Expired'           => 'your copoun has been created sesc',
        'applied'           => 'copoun code has been applied successfully',    
    ];
    
 
    
     
    
     public function checkEmptyCart(){
         
     }
    
    
    
     public function validateCheckoutForm($post,$route){
             if(
                 empty($post['first_name']) 
                 or empty($post['last_name']) 
                 or empty($post['Email']) 
                 or empty($post['country']) 
                 or empty($post['Phone']) 
                 or empty($post['adressLine1']) 
                 or empty($post['City'])
            ) {
                // the Imporant Fields are empty
                $this->flasherror('Please Fill All the required Fileds');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.checkout'));
            }
     }
    
    
     public function create($request,$response)  {
         
         
         // checkout Route
         $route     = $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.checkout'));
         $post      = validator::cleanify($request->getParams());
         $products  = Basket::getproducts();
         
         // check if the cart is empty
         if(empty(Basket::getTotalPrice())){
             $this->flasherror('you cart is empty!');
             return $route;
         }
         
         // check that user added the important informations
         $this->validateCheckoutForm($post,$route);
         
         // get payement method
         $this->getPaymentMethod($post,$route);
         
         // get coupon & check is a valid couponn
         $this->getCoupon($post,$route);
         
         // get user Info
         $this->getUserInfo($post,$route);         
         
         // get the tax
         $this->getTax($post,$route);         
         
         // caluclat the total price , apply the copon if exist , add the tax to payment
         $this->applyCouponToCart($post,$route);         
         
         // save the order to database
         $this->save_order($post,$route);
         
         // do the payment
         $this->makePayment($post,$route);
         
         
        // sandbox
        $enableSandbox = true;
         
        
    }
    

     public function checkpayement($request,$response){
         
        if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
            die('The response is missing the paymentId and PayerID');
        }
        
        // Paypal info.
        $client_id = $this->container->conf['pay.client_id'];
        $secret_id = $this->container->conf['pay.client_secret'];
        $return_url = $this->container->conf['pay.return_url'];
        $cancel_url = $this->container->conf['pay.cancel_url'];
         
        
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client_id,
                $secret_id
            )
        );   
         

        $payment = \PayPal\Api\Payment::get($_GET['paymentId'], $apiContext);
        $execution = (new \PayPal\Api\PaymentExecution())
        ->setPayerId($_GET['PayerID'])
        ->setTransactions($payment->getTransactions());

        $infos = [
            'transaction_id' => $payment->getId(),
            'email_address'  => $payment->getPayer()->getPayerInfo()->getEmail(),
            'payer_id'       => $payment->getPayer()->getPayerInfo()->getPayerId(),
            'phone'          => $payment->getPayer()->getPayerInfo()->getPhone(),
            'country'        => $payment->getPayer()->getPayerInfo()->getCountryCode(),
            'amount'         => $payment->getTransactions()[0]->getAmount()->getTotal(),
            'payment_status' => $payment->getState(),
        ];
         
 

    try {
        $result = $payment->execute($execution, $apiContext);
        if ($result->getState() == 'approved') {

            $_SESSION['buyingInfo']['total'] = $payment->getTransactions()[0]->getAmount()->getTotal();
            $_SESSION['buyingInfo']['transaction_id'] = $payment->getId();
            
            // save the order in database
            $this->add_order($_SESSION['buyingInfo'],$_SESSION['buyingProducts']);
            
            // clean the cart
            Basket::EmptyCart();
            
            // clean the sessions of info
            unset($_SESSION['buyingProducts']);
            unset($_SESSION['buyingInfo']);
            
            // send email to user to inform him
            
            
            $this->flash->addMessage('trueTransaction', 'Successful Payment, your order recieved successfully');
        
            header('location:' . $this->url('base'));
            exit(1);
            
            // Redirect to home with thank you popup 
        }else{
            die('something went wrong !');
        }
        
       
        
    } catch (\PayPal\Exception\PayPalConnectionException $e) {
        die('Bad Payement !'); 
    }
             
      
    }
    
    

    public function edit($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $order = Order::find($id);
       
        $products = $this->db->table('orderproducts')->whereOrder_id($id)->get();
        if($request->getMethod() == 'GET') {
            return $this->view->render($response, 'admin/orders/edit.twig', compact('order','products'));
        }
    }
    
    
    
    
    
}