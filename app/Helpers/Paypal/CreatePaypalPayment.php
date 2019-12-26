<?php


namespace App\Paypal;



class CreatePayment extends Paypal
{
    
    
    
    
    public function getPaypalInfo(){
        return [
            
        ];
    }
    
    public function makePayement(){
        
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

        $apiContext->setConfig(array(
            'mode' => 'sandbox'
        ));

        $list = new \PayPal\Api\ItemList();
         
         
         
        foreach(Basket::getproducts() as $item):
            $item = (new \PayPal\Api\Item())
            ->setName($item['name'])
            ->setPrice($item['price'])
            ->setCurrency('USD')
            ->setQuantity($item['quantity']);
            $list->addItem($item);  
        endforeach;
         
        $price = Basket::getTotalPrice();
         
        $details = (new \PayPal\Api\Details())
        ->setSubtotal($price);

        $amount = (new \PayPal\Api\Amount())
        ->setTotal($price)
        ->setCurrency('USD')
        ->setDetails($details);
         

        $transaction = (new \PayPal\Api\Transaction())
        ->setItemList($list)
        ->setDescription('buy products from Hamacrafts')
        ->setAmount($amount);

        $payment = new \PayPal\Api\Payment();
        $payment->setTransactions([$transaction]);
        $payment->setIntent('sale');
        $redirectUrls = (new \PayPal\Api\RedirectUrls())
        ->setReturnUrl($return_url)
        ->setCancelUrl($cancel_url);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setPayer((new \PayPal\Api\Payer())->setPaymentMethod('paypal'));


        try {
            $payment->create($apiContext);
            header('location:' . $payment->getApprovalLink());
            exit(1);

        } catch (\PayPal\Exception\PayPalConnectionException $e) {
                echo $e->getCode(); // Prints the Error Code
    echo $e->getData(); // Prints the detailed error message 
    die($e);
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home'));
            exit(1);                                                                                                                                                                 
         }
    }
    
    
    public function create()
    {
        $item1 = new Item();
        $item1->setName('Assignment Help Order')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku('123123') // Similar to `item_number` in Classic API
            ->setPrice($this->cost);


        $itemList = new ItemList();
        $itemList->setItems([$item1]);

        $payment = $this->Payment($itemList);

        $payment->create($this->apiContext);
        return redirect($payment->getApprovalLink());
    }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @param $itemList
     * @return Transaction
     */
    protected function Transaction( $itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount())
            ->setItemList($itemList)
            ->setDescription('Payment description')
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    protected function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $paypalRedirectUrl= config('services.paypal.url.redirect');
        $cost = $this->cost;
        $id = $this->id;
        print_r($cost, $id);
        $paypalRedirectUrl .="/".$id."/".$cost;
        $redirectUrls->setReturnUrl('http://localhost:8000/dashboard')
            ->setCancelUrl('http://localhost:8000/dashboard');
        return $redirectUrls;
    }

    /**
     * @param $itemList
     * @return Payment
     */
    protected function Payment($itemList): Payment
    {
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($this->payer())
            ->setRedirectUrls($this->RedirectUrls())
            ->setTransactions([$this->transaction($itemList)]);
        return $payment;
    }
}
