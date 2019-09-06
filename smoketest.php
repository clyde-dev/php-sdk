<?php
require "index.php";

$clyde = new Clyde("ck_live", "sk_live", true);

// $productOps["name"] = "Clyde Couch";
// $productOps["type"] = "furniture";
// $productOps["sku"] = "SKU78999";
// $productOps["price"] = 599.99;
// $productOps["description"] = "A cool couch.";
// $productOps["manufacturer"] = "Clyde Couch Co.";
// $productOps["barcode"] = "couch99";
// $productOps["imageLink"] = "clydeimagehosting.com/SKU789";
// $contracts = $clyde->getContracts();
// foreach ($contracts as $contract) {
//   print_r($contract);
// }

// $contracts = $clyde->getContractsForProduct();
// foreach ($contracts as $contract) {
//   print_r($contract);
// }

// print $clyde->getProducts();

$orderOpts["customer"] = [
  "firstName" => "Snpy",
  "lastName" => "Poodles",
  "email" => "edward@joinclyde.com",
  "phone" => "123-456-7890",
  "address1" => "311 Greenwich St",
  "address2" => "",
  "city" => "New York",
  "province" => "New York",
  "zip" => "10013",
  "country" => "US"
];

$orderOpts["lineItems"] = [
  [
    "id" => "2234567899",
    "productSku" => "123456",
    "price" => 14.99,
    "quantity" => 1,
    "serialNumber" => "pro456"
  ],
  [
    "id" => "2234567898",
    "productSku" => "123456",
    "price" => 14.99,
    "quantity" => 1,
    "serialNumber" => "pro456"
  ]
];

/*
$orderOpts["contractSales"] = [
  [
    "lineItemId" => "3987654321",
    "productSku" => "123456",
    "contractSku" => "TEST3Y",
    "productPrice" => 14.99,
    "contractPrice" => 10.00
  ],
  [
    "lineItemId" => "3987654322",
    "productSku" => "123456",
    "contractSku" => "TEST3Y",
    "productPrice" => 14.99,
    "contractPrice" => 10.00
  ]
];
*/

$state = [
  'isShipped' => false,
  'isDelivered' => false,
  'isRefunded' => true
];

$x = $clyde->updateLineItem("3234567890", '2234567899', $state);
print_r($state);
//print_r($orderOpts);
//$x = $clyde->createOrder("3234567890", $orderOpts);

//$x = $clyde->createProduct($productOps);
var_dump($x);

?>