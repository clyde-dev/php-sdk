A PHP library for the Clyde API. Head to https://api.joinclyde.com/docs for 
full documentation.


## Install

```console
$ composer require "clyde-sdk"
```

## Getting started

The framework supports all Clyde API Endpoints.  For complete information about the API, head
to the [docs](https://api.joinclyde.com/docs).

All endpoints require a valid `clientKey` and `clientSecret`.

```php

// Intantiate a Clyde object, first param is the key, then secret and then isLive(defaults to false)
$clyde = new Clyde('ck_your_key', 'sk_your_secret', false); 

```

Set `isLive` to `true` when you are done testing and ready to work with the live enviroment.  To start, leave `isLive` equal to 
`false`.  This will make all calls to the sandbox api and not effect your store products.

## Methods

Once an instance of the client has been created you use the following methods:

```php

$clyde = new Clyde('ck_your_key', 'sk_your_secret', false); 

// Get all products for your store
$products = $clyde.getProducts();

// Get a product based on the sku.  Sku is the first arguement
$product = $clyde.getProduct($sku);

// Create a product, see documentation for the complete list of available options.
$newProduct = $clyde.createProduct($productOptions);

// Update product.  First arguement is the sku, second is the updates.  See documentation for a full list of options and return structure.
$updatedProduct = $clyde.updateProduct($sku, $productOptions);

// Get contracts for a product.  Product sku is the first and only parameter.
$contracts = $clyde.getContractsForProduct($sku);

// Create an order.  Use this to create a contract sale or report lineitems of insurable products for 
// later sales.  Pass in the id of the order in your system as the first agruemnt.  Second arguement is 
// options for the order.  Please see full documentation for all available options.
$order = $clyde.createOrder($id, $orderOpts);

// Get a previously placed order.  First and only param is the order id in your system.
$order = $clyde.getOrder($id);

// Cancel a previously placed order. Use this to cancel all contract sales, or generally remove from our 
// system all line items in an order
$order = $clyde.cancelOrder($id);

// Get a contract sale.  Returns the contract sale referenced with the previously return clyde id
$contractSale = $clyde.getContractSale($clydeId);

// Cancel a contract sale.  Cancels the contract sale referenced with the previously return clyde id
$contractSale = $clyde.cancelContractSale($clydeId);

```

**All methods will return an associative array.  See full [documentation](https://api.joinclyde.com/docs) for the array structures**


## Error Handling

When an error occurs `clyde-sdk` will throw an error.  Use `try/catch` to propertly handle errors.

```php
try {
  $newProduct = $clyde.createProduct($productOptions);
}catch(Exception $e){
  //Do something with the exception
}
```

## License
MIT