<?php

class ClydeCrypto {

  static function signMessage(string $secret, string $method, string $url, $body, int $nonce, int $timestamp){
    $message = json_encode([$method, $url, $body, (string)$nonce, (string)$timestamp], JSON_UNESCAPED_SLASHES);
    $hash = hash_init('sha256');
    $hash_update = hash_update($hash, $message);
    $hash_final = hash_final($hash);
    $hmac = hash_hmac('sha512', $url.$hash_final, $secret, true);
    $hmac_final = base64_encode($hmac);
    return $hmac_final;
  }

} 

?>