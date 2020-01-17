<?php

class ClydeError {
  
  static function sendErrorMessage($res){
    $message = '';
    switch($res->getStatusCode()){
      case 400:
        $message = 'Resource not found '.$res->getStatusCode();
        break;
      case 401:
        $message = 'Unauthorized '.$res->getStatusCode();
        break;
      case 404:
        $message = 'Not found '.$res->getStatusCode();
        break;
      case 422:
        $message = 'Invalid Params '.$res->getStatusCode();
        break;
      case 500:
        $message = 'Server error '.$res->getStatusCode();
        break;
      default:
      $message = 'Unknown error '.$res->getStatusCode();
    }

    throw new Exception($message);
  }

}

?>