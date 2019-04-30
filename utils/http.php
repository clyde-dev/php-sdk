<?php

class ClydeError {
  
  static function sendErrorMessage($statusCode){
    $message = '';
    switch($statusCode){
      case 400:
        $message = 'Resource not found '.$statusCode;
        break;
      case 401:
        $message = 'Unauthorized '.$statusCode;
        break;
      case 422:
        $message = 'Invalid Params '.$statusCode;
        break;
      case 500:
        $message = 'Server error '.$statusCode;
        break;
      default:
      $message = 'Unknown error '.$statusCode;
    }

    throw new Exception($message);
  }

}

?>