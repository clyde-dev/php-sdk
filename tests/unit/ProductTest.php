<?php 
require_once __DIR__.'/../../index.php';

class ProductTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $clyde;
    
    protected function _before(){
      $this->clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', 'sk_live_vfRZVBfQAMuWas66', true); 
    }

    protected function _after(){
    }

    // tests
    public function testGetProducts(){
      $products = $this->clyde->getProducts();
      $expected['links'] = [
        'self' => 'https://clyde-ed.ngrok.io/products?'
      ];
      $this->assertEquals($products['links'], $expected['links']);
      $this->assertEquals($products['data'][0]['type'], 'product');

      $products = $this->clyde->getProducts([]);
      $this->assertEquals($products['links'], $expected['links']);
      $this->assertEquals($products['data'][0]['type'], 'product');

      $products = $this->clyde->getProducts([], 'ippop-in-strangers-houses');
      $this->assertEquals($products['links'], $expected['links']);
      $this->assertEquals($products['data'][0]['type'], 'product');
    }

    public function testGetProduct(){
      $product = $this->clyde->getProduct('123456');
      $expected['data'] = ['type' => 'product'];

      $this->assertEquals($product['data']['type'], $expected['data']['type']);

      // With IP
      $product = $this->clyde->getProduct('123456', 'ip-address-iw');
      $this->assertEquals($product['data']['type'], $expected['data']['type']);
    }
    /*
    public function testCreateProduct(){
      $productOps['name'] = 'charlie';
      $productOps['type'] = 'personnn';
      $productOps['sku'] = uniqid();
      $productOps['price'] = 3.70;

      $newProduct = $this->clyde->createProduct($productOps);
      $this->assertEquals($newProduct['data']['type'],'product');
      $this->assertEquals($newProduct['data']['attributes']['sku'],$productOps['sku']);
    }
    */

    public function testGetContractsForProduct(){
      $product = $this->clyde->getContractsForProduct('123456');
      $this->assertEquals($product['data'][0]['type'],'contract');

      // With IP
      $product = $this->clyde->getContractsForProduct('123456', 'iPoop-in-strang-places');
      $this->assertEquals($product['data'][0]['type'],'contract');
    }
    
}