<?php

class ClydeCrypto {

  static function signMessage(string $secret, string $method, string $url, $body, int $nonce, int $timestamp){
    $message = json_encode([$method, $url, $body, "".$nonce, "".$timestamp], JSON_UNESCAPED_SLASHES);
    $hash_digest = hash('sha256', $message, false);
    $hash_digest = hex2bin($hash_digest);
    $hmac_digest = hash_hmac('sha512',$url.$hash_digest , utf8_encode($secret),false);
    $hmac_digest = hex2bin($hmac_digest);
    $hmac_digest = base64_encode($hmac_digest);
    return $hmac_digest;
  }

} 

?>