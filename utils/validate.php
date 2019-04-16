<?php

function isAssoc(array $arr){
  if (array() === $arr) return false;
  return array_keys($arr) !== range(0, count($arr) - 1);
}

class ClydeValidate {

  static function validateParams($requiredParams, $opts, $friendlyName){
    if(isAssoc($opts)){
      $opts = [$opts];
    }
    
    foreach ($opts as &$opt) {
      foreach ($requiredParams as &$value) {
        if(!$opt[$value]){
          throw new Exception('Missing '.$value);
        }
      }
    }

    return true;
  }

}

?>