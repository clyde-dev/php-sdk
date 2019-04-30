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
// Instantiate a Clyde object, first paramater is the key, second parameter secret and then isLive(defaults to false)
$clyde = new Clyde('ck_your_key', 'sk_your_secret', false); 

```

When testing, Set `isLive` to `false`(third arguement on the class contructor), and use test keys instead of live keys.  This will allow you to test without creating active customers or contracts. When you are done testing, set `isLive` to `true` and use your live keys. **Note that at this point all contracts orders are considered live and valid**

## Methods

Once an instance of the sdk has been created you use the following methods:

```php
$clyde = new Clyde('ck_your_key', 'sk_your_secret', false); 

// Get all products for your store.
$products = $clyde.getProducts();

// Get a product based on the sku.  Sku is the first arguement.
$product = $clyde.getProduct($sku);

// Create a product, see documentation for the complete list of available options.
$newProduct = $clyde.createProduct($productOptions);

// Update product.  First arguement is the sku, second is an associative array with the product updates.  See documentation for a full list of options and return structure.
$updatedProduct = $clyde.updateProduct($sku, $productOptions);

// Get contracts for a product.  Product sku is the first and only parameter.
$contracts = $clyde.getContractsForProduct($sku);

// Create an order.  Use this to create a contract sale or report lineitems of insurable products for 
// later sales.  Pass in the id of the order in your system as the first agruemnt.  Second arguement is an
// associative array with the parameters of your order.  Please see full documentation for all available options and required parameters on orders.
$order = $clyde.createOrder($id, $orderOpts);

// Get a previously placed order.  First and only parameter is the order id in your system.
$order = $clyde.getOrder($id);

// Cancel a previously placed order. Use this to cancel all contract sales, or generally remove from our 
// system all line items associated with an order.
$order = $clyde.cancelOrder($id);

// Get a contract sale.  Returns the contract sale referenced with the previously return clyde id.
$contractSale = $clyde.getContractSale($clydeId);

// Cancel a contract sale.  Cancels the contract sale referenced with the previously return clyde id.
$contractSale = $clyde.cancelContractSale($clydeId);

```

**All methods will return an associative array.  See full [documentation](https://api.joinclyde.com/docs) for the array structures returned with each call**


## Error Handling

When an error occurs `clyde-sdk` will throw an error.  Use `try/catch` to propertly handle errors.

```php
try {
  $newProduct = $clyde.createProduct($productOptions);
}catch(Exception $e){
  // Do something with the exception
}
```

## License
MIT