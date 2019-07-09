<?php
require "index.php";

$clyde = new Clyde("ck_live_3XhSsEEmHgpbBufz", "sk_live_jQVxQaGna8yHdcQe", true);

// $contracts = $clyde->getContracts();
// foreach ($contracts as $contract) {
//   print_r($contract);
// }

$contracts = $clyde->getContractsForProduct();
foreach ($contracts as $contract) {
  print_r($contract);
}

// print $clyde->getProducts();
?>