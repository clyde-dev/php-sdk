<?php
require 'index.php';

$clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', 'sk_live_vfRZVBfQAMuWas66', true); 
//$clyde = new Clyde('ck_live_cN8awGYN8KMvT2da', ''); 
try {

  $productOps['name'] = 'charlie';
  $productOps['type'] = 'personnn';
  $productOps['sku'] = 'monstasaiddbout';

  $sku = 'monstasaidbout';
  $productOps['price'] = 3.70;

  //echo $clyde->createProduct($productOps);
  //var_dump($clyde->getProducts());
  
  //echo $clyde->updateProduct($sku, $productOps);

  //echo $clyde->getContractsForProduct('123456');

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

  $clyde->getOrder('11105');

  //$stuff = $clyde->cancelOrder('11105');
  $more_stuf = $clyde->createOrder('11105');
  var_dump($stuff);
  //var_dump($more_stuff);
  //echo $clyde->cancelContractSale('adeab382-946b-4c2f-8316-bc75c782f51f');
  
}catch(Exception $e){
  var_dump($e->getMessage());
}

?>

