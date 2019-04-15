<?php
require "vendor/autoload.php";
require "utils/crypto.php";
require "utils/http.php";

class Clyde  {
  private $client;
  private $client_key;
  private $client_secret;

  function __construct(string $key, string $secret){
    $this->client = new \GuzzleHttp\Client(["base_uri" => "http://localhost:3100"]);
    $this->client_key = $key;
    $this->client_secret = $secret;
  }

  private function buildHeaders(string $signature){
    $date = new DateTime();
    $nonce = $date->getTimestamp();
    $timestamp = $date->getTimestamp();

    $headers['headers'] = [
      'Authorization' => $this->client_key.':'.$signature,
      'X-Auth-Timestamp' => $timestamp,
      'X-Auth-Nonce' => $nonce,
      'Content-Type' => 'application/vnd.api+json'
    ];

    return $headers;
  }

  public function getProducts(){
    $uri = '/products';
    
    $res = $this->client->request('GET', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function getProduct(string $sku){
    $uri = '/products/'.sku;
    $res = $this->client->request('GET', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function createProduct($opts){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }

    $uri = '/products';
    $res = $this->client->request('POST', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);

    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function updateProduct(string $sku, $opts){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }
    $uri = '/products/'.$sku;
    $res = $this->client->request('PUT', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
  
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function getContractsForProduct(string $sku){
    $uri = '/products/'.$sku.'/contracts';
    $res = $this->client->request('GET', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function createOrder(string $id, $opts){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }
    $uri = '/orders';
    $res = $this->client->request('POST', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function getOrder(string $orderId){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }

    $uri = '/orders/'.$orderId;
    $res = $this->client->request('GET', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function cancelOrder(string $orderId){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }

    $uri = '/orders/'.$orderId;
    $res = $this->client->request('DELETE', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 204){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function getContractSale(string $contractSaleID){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }

    $uri = '/contract-sales/'.$contractSaleID;
    $res = $this->client->request('GET', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 200){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }

  public function cancelContractSale(string $contractSaleID){
    if(!$this->client_secret){
      throw new Exception('Need a valid secreat to call '.__FUNCTION__);
    }

    $uri = '/contract-sales/'.$contractSaleID;
    $res = $this->client->request('DELETE', $uri, ['headers' => $this->buildHeaders(''), 'http_errors' => false ]);
    
    if($res->getStatusCode() !== 204){
      ClydeError::sendErrorMessage($res->getStatusCode());
    }

    return $res->getBody();
  }
  
} 

$clyde = new Clyde('ck_live_cN8awGYN8KMvT2da','sk_live_vfRZVBfQAMuWas66' ); 
//$clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', ''); 
try {
  echo $clyde->createProduct(['x'=>'y']);
}catch(Exception $e){
  var_dump($e->getMessage());
}
?>

