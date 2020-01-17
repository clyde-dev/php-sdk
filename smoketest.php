<?php
require "index.php";
//Currently healthyline
//$clyde = new Clyde("ck_live_bEwQNDXuB4Mcr1aM", "sk_live_zvjWxtpHmY9RNbZp", true);

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

// $orderOpts["customer"] = [
//   "firstName" => "Snpy",
//   "lastName" => "Poodles",
//   "email" => "edward@joinclyde.com",
//   "phone" => "123-456-7890",
//   "address1" => "311 Greenwich St",
//   "address2" => "",
//   "city" => "New York",
//   "province" => "New York",
//   "zip" => "10013",
//   "country" => "US"
// ];

// $orderOpts["lineItems"] = [
//   [
//     "id" => "2234567899",
//     "productSku" => "123456",
//     "price" => 14.99,
//     "quantity" => 1,
//     "serialNumber" => "pro456"
//   ],
//   [
//     "id" => "2234567898",
//     "productSku" => "123456",
//     "price" => 14.99,
//     "quantity" => 1,
//     "serialNumber" => "pro456"
//   ]
// ];


// 2422367 - error Unauthorized 401
// 2422459 - sent successfully in your system
// 2422349 - error Unauthorized 401


// $orderOpts["customer"] = [
//   "firstName" => "Ted",
//   "lastName" => "Kurtas",
//   "email" => "thoratreides@gmail.com",
//   "phone" => "9178595309",
//   "address1" => "6919 DOUGLASTON PKWY PH",
//   "address2" => "",
//   "city" => "DOUGLASTON",
//   "province" => "New York",
//   "zip" => "11362-1942",
//   "country" => "US"
// ];

// $orderOpts["lineItems"] = [
//   [
//     "id" => "2327743",
//     "productSku" => "TAO-K-PhP-110V",
//     "price" => 2249.1,
//     "quantity" => 1,
//     "serialNumber" => "TAO-K-PhP-110V"
//   ],
// ];

// $orderOpts["contractSales"] = [];

// $state = [
//   'isShipped' => false,
//   'isDelivered' => false,
//   'isRefunded' => true
// ];

//$x = $clyde->updateLineItem("3234567890", '2234567899', $state);
//print_r($state);
//print_r($orderOpts);
//$x = $clyde->createOrder("2423016", $orderOpts);

//$x = $clyde->createProduct($productOps);
//var_dump($x);


// $clyde2 = new Clyde("ck_live_bEwQNDXuB4Mcr1aM", "sk_live_zvjWxtpHmY9RNbZp", true);
// $orderOpts["customer"] = [
//      "firstName" => "Sherry",
//      "lastName" => "Ferry",
//      "email" => "sherryf2@windstream.net",
//      "phone" => "4789672416",
//      "address1" => "416 MAIN ST W",
//      "address2" => "",
//      "city" => "MARSHALLVILLE",
//      "province" => "Georgia",
//      "zip" => "31057-9732",
//      "country" => "US",
//  ];
//  $orderOpts["lineItems"] = [
//      [
//          "id" => "5307912",
//          "productSku" => "5AJ-SEAT-PP-110V",
//          "price" => 539.1,
//          "quantity" => 1,
//          "serialNumber" => "5AJ-SEAT-PP-110V"
//      ]
//  ];
//  $orderOpts["contractSales"] = [];
 //$x = $clyde2->createOrder("2418489", $orderOpts);

$orderOpts["customer"] = [
    "firstName" => "test",
    "lastName" => "test",
    "email" => "edward@joinclyde.com",
    "phone" => "4034977494",
    "address1" => "Test 3",
    "address2" => "",
    "city" => "New York",
    "province" => "NY",
    "zip" => "11101",
    "country" => "US",
];
$orderOpts["lineItems"][] = [
    "id" => "2308283",
    "productSku" => "27623156-p2f-uk-standard-plug",
    "price" => 1975.80,
    "quantity" => 1,
    "serialNumber" => "x"
];

$orderOpts["contractSales"] = [
  "lineItemId" => "2308283",
  "productSku" => "27623156-p2f-uk-standard-plug",
  "contractSku" => "TEST1Y",
  "productPrice" => 1975.80,
  "contractPrice" => 2.49 + 1.5
];

function test_wds_clyde_create_order($order_id, $orderOpts) {
  $order = array(
      'error' => '',
      'data' => []
  );
  try {
    //healthy line
      $clydeCreateOrder = new Clyde("ck_live_bEwQNDXuB4Mcr1aM", "sk_live_zvjWxtpHmY9RNbZp", true, true);
    //local
      //$clydeCreateOrder = new Clyde("ck_live_4sZbddCFmfJpjpK2", "sk_live_8Fp2snypeN6VHRVa", true, true);
      $order['data'] = $clydeCreateOrder->createOrder($order_id, $orderOpts);
  } catch ( Exception $e ) {
      $order['error'] = $e->getMessage();
      $code = $e->getTrace();
      $order['Exception'] = $e;
      var_dump($order['error']);
  }
  return $order;
}

test_wds_clyde_create_order("24185888", $orderOpts);

//$x = $clyde2->createOrder("2418509", $orderOpts);
//var_dump($x);
?>