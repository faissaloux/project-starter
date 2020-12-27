<?php

use \App\Models\Data;
use \Carbon\Carbon;
    
    
// security , disable direct access
defined('BASEPATH') or exit('No direct script access allowed');

  
$app->get('/search', function($request, $response){
    $passport = $_GET['passport'];
    $data = Data::where('passport', $passport)->get();
    
    return $response->withJson($data, 200);
});

$app->get('/payment/{id}', function($request, $response, $args){
    $id = rtrim($args['id'], '/');
    $data = Data::find($id);
    $data->paid_at = Carbon::now();
    if($data->save())
        return $response->withJson(['succes' => 'payment done successfully'], 200);
    else return $response->withJson(['error' => 'Something went wrong']);
});