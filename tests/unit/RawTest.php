<?php 
require_once __DIR__.'/../../index.php';

class RawTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $clyde;
    
    protected function _before(){
      $this->clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', 'sk_live_vfRZVBfQAMuWas66'); 
    }

    protected function _after(){
    }

    // tests
    public function testRawProduct(){
      $product = $this->clyde->sendRaw('/products/123456', 'GET', null);
      $expected['data'] = ['type' => 'product'];

      $this->assertEquals($product['data']['type'], $expected['data']['type']);
    }

    public function testRawProductCreate(){
      $productOps['name'] = 'charlie';
      $productOps['type'] = 'personnn';
      $productOps['sku'] = uniqid();
      $productOps['price'] = 3.70;

      $body['data'] = [
        'type' => 'product',
        'attributes' => $productOps
      ];

      $newProduct = $this->clyde->sendRaw('/products', 'POST', $body);
      $this->assertEquals($newProduct['data']['type'],'product');
      $this->assertEquals($newProduct['data']['attributes']['sku'],$productOps['sku']);
    }

    public function testRawFail(){
      try {
        $this->clyde->sendRaw('/reallybadrul', 'GET', null);
      }catch (Exception $e){
        $this->assertEquals($e->getMessage(), 'Unauthorized 401');
      }
    }

}