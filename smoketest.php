<?php
require "index.php";

$clyde = new Clyde("ck_test", "sk_test", true);

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
  "firstName" => "Edward",
  "lastName" => "Gaudio",
  "email" => "edwardgaudio@gmail.com",
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
    "id" => "1234567899",
    "productSku" => "123456",
    "price" => 14.99,
    "quantity" => 1,
    "serialNumber" => "pro456"
  ],
  [
    "id" => "1234567899",
    "productSku" => "123456",
    "price" => 14.99,
    "quantity" => 1,
    "serialNumber" => "pro456"
  ]
];

$orderOpts["contractSales"] = [
  [
    "lineItemId" => "0987654321",
    "productSku" => "123456",
    "contractSku" => "TEST3Y",
    "productPrice" => 14.99,
    "contractPrice" => 10.00
  ],
  [
    "lineItemId" => "0987654321",
    "productSku" => "123456",
    "contractSku" => "TEST3Y",
    "productPrice" => 14.99,
    "contractPrice" => 10.00
  ]
];



print_r($orderOpts);
$x = $clyde->createOrder("1234567890", $orderOpts);

//$x = $clyde->createProduct($productOps);
var_dump($x);

?>