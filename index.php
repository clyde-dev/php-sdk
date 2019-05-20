<?php
require "vendor/autoload.php";
require "utils/crypto.php";
require "utils/http.php";
require "utils/validate.php";

class Clyde  {
  private $client;
  private $clientKey;
  private $clientSecret;
  private $baseUrl = "https://api.joinclyde.com";
  private $methodWhitelist = ['GET', 'POST', 'PUT', 'DELETE'];

  function __construct(string $key, string $secret, bool $isLive = false){
    $secretBits = explode("_", $secret);
    $keyBits = explode("_", $key);
    if($isLive === false && ($secretBits[1] === 'live' || $keyBits[1] === 'live') ){
      throw new Exception('SDK in test mode with live secret/key. Please set SDK to live or keys/secret to test');
    }
    $this->client = new \GuzzleHttp\Client();
    $this->clientKey = $key;
    $this->clientSecret = $secret;
  }

  private function buildOpts(string $method, string $uri, $body, $ip = false){
    $date = new DateTime();
    $nonce = $date->getTimestamp() + rand(1000, 9000000);
    $timestamp = $date->getTimestamp();
    $signature = ClydeCrypto::signMessage($this->clientSecret, $method, $uri, $body, $nonce, $timestamp);
    $headers['http_errors'] = false;
    $headers['json'] = ($body !== '') ? $body : new stdClass;

    $headers['headers'] = [
      'Authorization' => $this->clientKey.':'.$signature,
      'X-Auth-Timestamp' => $timestamp,
      'X-Auth-Nonce' => $nonce,
      'Content-Type' => 'application/vnd.api+json'
    ];
    
    if($ip !== false){
      $headers['headers']['x-clyde-client-ip'] = $ip;
    }

    return $headers;
  }

  private function buildQueryString($opts, $whiteList){
    $queryString = '';
    
    if(sizeof($opts) > 0){
      foreach ($opts as $opt => $value) {
        if(in_array($opt, $whiteList)){
          if(is_array($value)){
            $queryString .= $opt.'='.implode(',', $value).'&';
          }else{
            $queryString .= $opt.'='.$value.'&';
          }
        }
      }
    }

    if( strlen($queryString) > 0 ){
      $queryString = '?'. preg_replace('/(\&)$/', '', $queryString);
    }

    return $queryString;
  }

  public function sendRaw(string $path, string $method, $body, $ip = false){
    
    if(!in_array(strtoupper($method), $this->methodWhitelist)){
      throw new Exception($method.' not allowed');
    }
    $uri = $this->baseUrl.$path;
    
    $res = $this->client->request(strtoupper($method), $uri, $this->buildOpts(strtoupper($method), $uri, $body, $ip));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function getProducts($opts = false, $ip = false){
    $uri = $this->baseUrl.'/products';
    $method = 'GET';
    $body = '';

    if($opts){
      $uri .= $this->buildQueryString($opts, ['sku', 'page']);
    }
    
    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body, $ip));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function getProduct(string $sku, $ip = false){
    $uri = $this->baseUrl.'/products/'.$sku;
    $method = 'GET';
    $body = '';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body, $ip));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function createProduct($opts){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    //Throws when a param is missing
    ClydeValidate::validateParams(['name', 'type', 'sku', 'price'], $opts, 'Create Product');

    $method = 'POST';
    $body['data'] = [
      'type' => 'product',
      'attributes' => $opts
    ];
    $uri = $this->baseUrl.'/products';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));

    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      //Throws
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function updateProduct(string $sku, $opts){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    if(!$sku || $opts === []){
      throw new Exception('Need a valid sku and update array');
    }

    $uri = $this->baseUrl.'/products/'.$sku;
    $method = 'PUT';
    $body['data'] = [
      'type' => 'product',
      'attributes' => $opts
    ];

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
  
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function getContractsForProduct(string $sku, $ip = false){
    $uri = $this->baseUrl.'/products/'.$sku.'/contracts';
    $method = 'GET';
    $body = '';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body, $ip));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      //throws, so this is effectively an early return
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function deleteProduct(string $sku){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    $uri = $this->baseUrl.'/products/'.$sku;
    $method = 'DELETE';
    $body = '';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      //throws, so this is effectively an early return
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function createOrder(string $id, $opts){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    if($opts['customer']){
      ClydeValidate::validateParams([
        'firstName', 'lastName', 'email', 'phone',
        'address1', 'city', 'province', 'zip', 'country',
      ], $opts['customer'], 'Customer');
    }

    $uri = $this->baseUrl.'/orders';
    $method = 'POST';
    $body['data'] = [
      'type' => 'order',
      'id' => $id,
      'attributes' => [
        'customer' => $opts['customer']
      ]
    ];

    if(isset($opts['total'])){
      $body['data']['attributes']['orderTotal'] = $opts['total'];
    }

    if($opts['contractSales']){
      ClydeValidate::validateParams([
        'lineItemId', 'contractPrice', 'contractSku', 'productSku'
      ], $opts['contractSales'], 'Contract');
      $body['data']['attributes']['contractSales'] = [$opts['contractSales']];
    }

    if($opts['lineItems']){
      ClydeValidate::validateParams([
        'id', 'productSku', 'price', 'quantity', 'serialNumber'
      ], $opts['lineItems'], 'Line item');
      $body['data']['attributes']['lineItems'] = [$opts['lineItems']];
    }

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function getOrder(string $orderId){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    $uri = $this->baseUrl.'/orders/'.$orderId;
    $method = 'GET';
    $body = '';
    $opts = $this->buildOpts($method, $uri, $body);
    $res = $this->client->request($method, $uri, $opts);
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function cancelOrder(string $orderId){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    $uri = $this->baseUrl.'/orders/'.$orderId;
    $method = 'DELETE';
    $body = '';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      //throws, so this is effectively an early return
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function getContractSale(string $contractSaleID){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    $uri = $this->baseUrl.'/contract-sales/'.$contractSaleID;
    $method = 'GET';
    $body = '';
    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }

  public function cancelContractSale(string $contractSaleID){
    if(!$this->clientSecret){
      throw new Exception('Need a valid secret to call '.__FUNCTION__);
    }

    $uri = $this->baseUrl.'/contract-sales/'.$contractSaleID;
    $method = 'DELETE';
    $body = '';

    $res = $this->client->request($method, $uri, $this->buildOpts($method, $uri, $body));
    
    if($res->getStatusCode() < 200 || $res->getStatusCode() >= 300){
      ClydeError::sendErrorMessage($res->getStatusCode());
      return;
    }

    return json_decode((string)$res->getBody(), true);
  }
  
} 
?>

