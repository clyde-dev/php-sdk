<?php
require "vendor/autoload.php";

class Clyde  {
  private $client;
  private $client_key;
  private $client_secret;

  function __construct(string $key, string $secret){
    $this->client = new \GuzzleHttp\Client(["base_uri" => "http://localhost:3100"]);
    $this->client_key = $key;
    $this->client_secret = $secret;
  }

  private function buildHeaders(){
    $date = new DateTime();
    $nonce = $date->getTimestamp();
    $timestamp = $date->getTimestamp();

    $headers['headers'] = [
      'Authorization' => $this->client_key.':',
      'X-Auth-Timestamp' => $timestamp,
      'X-Auth-Nonce' => $nonce,
      'Content-Type' => 'application/vnd.api+json'
    ];

    return $headers;
  }

  public function getProducts(){
    $uri = '/products';
    
    $res = $this->client->request('GET', $uri, $this->buildHeaders());
    return $res->getBody();
  }

  public function getProduct(string $sku){
    $uri = '/products/'.sku;
    $res = $this->client->request('GET', $uri, $this->buildHeaders());
    return $res->getBody();
  }

  public function createProduct($opts){
    $uri = '/products';
    $res = $this->client->request('POST', $uri, $this->buildHeaders());
  }

  public function updateProduct(string $sku, $opts){
    $uri = '/products/'.$sku;
    $res = $this->client->request('PUT', $uri, $this->buildHeaders());
  }

  public function getContractsForProduct(string $sku){
    $uri = '/products/'.$sku.'/contracts';
    $res = $this->client->request('GET', $uri, $this->buildHeaders());
  }

  public function createOrder(string $id, $opts){
    $uri = '/orders';
    $res = $this->client->request('POST', $uri, $this->buildHeaders());
  }

  public function getOrder(string $orderId){
    $uri = '/orders/'.$orderId;
    $res = $this->client->request('GET', $uri, $this->buildHeaders());
  }

  public function cancelOrder(string $orderId){
    $uri = '/orders/'.$orderId;
    $res = $this->client->request('DELETE', $uri, $this->buildHeaders());
  }

  public function getContractSale(string $contractSaleID){
    $uri = '/contract-sales/'.$contractSaleID;
    $res = $this->client->request('GET', $uri, $this->buildHeaders());
  }

  public function cancelContractSale(string $contractSaleID){
    $uri = '/contract-sales/'.$contractSaleID;
    $res = $this->client->request('DELETE', $uri, $this->buildHeaders());
  }
  
} 

$clyde = new Clyde('ck_live_cN8awGYN8KMvT2da','sk_live_vfRZVBfQAMuWas66' ); 
echo $clyde->getProducts();
?>

