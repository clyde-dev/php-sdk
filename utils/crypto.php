<?php
class clydeCrypto {
  private function makeMessage(string $method, string $url, mixed $body, int $nonce, int $timestamp){

  }

  public function signMessage(string $secret, string $method, string $url,$body, int $nonce, int $timestamp){
    
    $hash = hash_init('sha256');
    $hash_update = hash_update($hash, 'x');
    $hash_final = hash_final($hash);
    
    $hmac = hash_hmac('sha512', 'x', 'x', true);
    $hmac_final = base64_encode($hmac);
    
    return $hmac_final;
  }
} 

//$x = new clydeCrypto();

//echo $x->signMessage('x', 'x', 'x', 'x', 1,1);

/*
const _makeMessage = (method:any, url:any, body:any, nonce:any, timestamp:any) => {
  const message = JSON.stringify([method, url, body, ""+nonce, ""+timestamp]);
  return message;
}

const signMessage = (secret:any, method:any, url:any, body:any, nonce:any, timestamp:any) => {
  const message = _makeMessage(method.toUpperCase(), url, body, nonce, timestamp);
  const hash = crypto.createHash('sha256');
  const hmac = crypto.createHmac('sha512', Buffer.from(secret));
  const hash_digest = hash.update(message).digest();
  const hmac_digest = hmac.update(url + hash_digest).digest('base64');
  return hmac_digest;
}
*/
?>