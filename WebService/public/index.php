<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

require '../includes/DbOperations.php';
$config = ['settings' => ['displayErrorDetails' => true]];
$app = new Slim\App($config);



$app->post('/createcard', function(Request $request , Response $response){

  if(!HaveEmptyParameters(array('Size', 'Paper_Type', 'Folding', 'Sides_Printed', 'Quantity', 'Price'),$request, $response)){


      $request_data = $request->getParsedBody();
      $Size=$request_data['Size'];
      $Paper_Type=$request_data['Paper_Type'];
      $Folding=$request_data['Folding'];
      $Sides_Printed=$request_data['Sides_Printed'];
      $Quantity=$request_data['Quantity'];
      $Quantity=$request_data['Price'];





      $db = new DbOperations;
      $result = $db->CreateMedicament($Size,$Paper_Type,$Folding,$Sides_Printed, $Quantity,$Price );
      if($result== CARD_CREATED){
          $message = array();
          $message['error'] = false ;
          $message['message'] = 'Medicament enregistre';
          $response->write(json_encode($message));
          return $response
                      ->withHeader('Content-type' , 'application/json')
                      ->withStatus(201);
      }else if($result== CARD_FAILURE){

          $message = array();
          $message['error'] = true ;
          $message['message'] = 'Une erreur s est produite ';
          $response->write(json_encode($message));
          return $response
                      ->withHeader('Content-type' , 'application/json')
                      ->withStatus(201);
      }else if($result== CARD_EXISTS){
        $message = array();
        $message['error'] = true ;
        $message['message'] = 'Le card existe déjà';
        $response->write(json_encode($message));
        return $response
                    ->withHeader('Content-type' , 'application/json')
                    ->withStatus(201);
      }

  }
});


$app->get('/GetAllCards', function(Request $request , Response $response){



            $db = new DbOperations;
            $card=$db->getAllCards();
            $response_data = array();
            $response_data['error'] =false ;

            $response_data['card'] = $card;

            $response->write(json_encode($response_data));
            return $response
                        ->withHeader('Content-type' , 'application/json')
                        ->withStatus(200);//OK

          });



function HaveEmptyParameters($required_params,$request, $response){
    $error=false;
    $error_params='';
    $error_detail=array();
    $card=array();
    $request_params=$request->getParsedBody();
    foreach ($required_params as $param) {
    if(!isset($request_params[$param]) ||  strlen($request_params[$param])<=0 ){
            $error=true;
            $error_params.=$param . ', ';
            $error_detail['error'] = $param;
          }

    }
    if($error){
      $error_detail=array();
      $error_detail['error'] = true;
      $error_detail['card']=$card;

      $response->write(json_encode($error_detail));
    }

    return $error;

}

$app->run();
