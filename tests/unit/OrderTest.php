<?php 
require_once __DIR__.'/../../index.php';

class OrderTest extends \Codeception\Test\Unit
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
    public function testCreateOrder(){
      $orderOpts['customer'] = [
        'firstName' => 'Peter',
        'lastName' => 'Alonso',
        'email' => 'eddd@joinclyde.com',
        'phone' => '2039271893',
        'address1' => '2704 Hoyt ave s',
        'address2' => '5b',
        'city' => 'New York',
        'province' => 'NY',
        'zip' => '11102',
        'country' => 'US'
      ];

      $orderOpts['contractSales'] = [
        'lineItemId' => '1234567890',
        'productSku' => '123456',
        'productPrice' => 50,
        'contractSku' => 'TEST2Y',
        'contractPrice' => 10
      ];

      $orderOpts['lineItems'] = [
        'id' => '123499999',
        'productSku' =>  '123456',
        'price' =>  50,
        'quantity' =>  1,
        'serialNumber' =>  '1234kldalkjwe'
      ];

      $newOrder = $this->clyde->createOrder('11105', $orderOpts);
      $this->assertEquals($newOrder['data']['type'], 'order');
      $this->assertArrayHasKey('customer', $newOrder['data']['attributes']);
      $this->assertArrayHasKey('clydeId', $newOrder['data']['attributes']);
      $this->assertArrayHasKey('lineItems', $newOrder['data']['attributes']);
      $this->assertArrayHasKey('contractSales', $newOrder['data']['attributes']);
    }

    public function testGetOrder(){
      $order = $this->clyde->getOrder('11105');
      
      $expected['customer'] = [
        'email' => 'eddd@joinclyde.com',
        'firstName' => 'Peter',
        'lastName' => 'Alonso',
        'address' => '2704 Hoyt ave s',
        'address2' => '5b',
        'phone' => '203-927-1893',
        'city' => 'New York',
        'province' => 'NY',
        'zip' => '11102',
        'country' => 'US'
      ];

      $expected['contractSales'][0] = [
        'lineItemId' => '1234567890',
        'productSku' => '123456',
        'contractSku' => '123456',
        'productPrice' => 99.99,
        'contractPrice' => 13,
        'serialNumber' => null
      ];

      $this->assertEquals($order['data']['type'], 'order');
      $this->assertEquals($order['data']['attributes']['customer'], $expected['customer']);
      $this->assertEquals($order['data']['attributes']['contractSales'][0]['lineItemId'], $expected['contractSales'][0]['lineItemId']);
    }
    
    public function testCancelOrder(){
      $order = $this->clyde->cancelOrder('11105');
      $this->assertNull($order);
    }
}