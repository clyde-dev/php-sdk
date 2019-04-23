<?php 
require_once __DIR__.'/../../index.php';

class ContactSaleTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $clyde;
    private $testID = '01420bd5-cde4-4f15-90fb-b65f97da403d';
    
    protected function _before(){
      $this->clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', 'sk_live_vfRZVBfQAMuWas66', true);
    }

    protected function _after(){
    }

    // tests
    public function testGetContractSale(){
      $contractSale = $this->clyde->getContractSale($this->testID);
      
      $expected['customer'] = [
        'email' => 'eddd@joinclyde.com',
        'firstName' => 'Peter',
        'lastName' => 'Alonso',
        'address1' => '2704 Hoyt ave s',
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

      $this->assertEquals($contractSale['data']['type'], 'contractSale');
      $this->assertEquals($contractSale['data']['attributes']['customer'], $expected['customer']);
    }
    
    public function testCancelContractSale(){
      $contractSale = $this->clyde->cancelContractSale('01420bd5-cde4-4f15-90fb-b65f97da403d');
      $this->assertNull($contractSale);
    }
}