# Clyde API

A PHP library for the Clyde API. Head to https://api.joinclyde.com/docs for full documentation.


## Install

```console
$ composer require "clyde-sdk"
```


## Getting started

The framework supports all Clyde API Endpoints. For complete information about the API, head to the [docs](https://api.joinclyde.com/docs).

All endpoints require a valid `clientKey` and `clientSecret`.

```php
// Instantiate a Clyde object. First paramater is the key,
// second parameter the secret, and last is isLive (defaults to false).
$clyde = new Clyde('ck_your_key', 'sk_your_secret', true); 

```

When testing, Set `isLive` to `false` (third arguement on the class contructor), and use test keys instead of live keys. This will allow you to test without creating active customers or contracts. When you are done testing, set `isLive` to `true` and use your live keys. **Note that at this point all contract orders are considered live and valid.**


## Methods

**All methods will return an associative array. See full [documentation](https://api.joinclyde.com/docs) for the array structures returned with each call.**

### Create Product

Create a product. Please see [documentation](https://api.joinclyde.com/docs) for available properties.

```php
$newProduct = $clyde.createProduct($productOptions);
```

### Update Product

Update your product. First parameter is the product SKU; second is an associative array with the product updates. See [documentation](https://api.joinclyde.com/docs) for a full list of options and return structure.

```php
$updatedProduct = $clyde.updateProduct($sku, $productOptions);
```

### Get One Product

Get only one product. Product SKU is the first and only parameter.

```php
$product = $clyde.getProduct($sku);
```

### Get Many Products

Get all products associated with your store. Optionally, you may pass in an opts object with a page number or associative array of SKUs to retrieve a particular page or a subset of SKUs.

```php
$products = $clyde.getProducts();
```

### Get Contracts for a Product

Get all available contracts for a product. Product SKU is the first and only parameter.

```php
$contracts = $clyde.getContractsForProduct($sku);
```

### Create Order

Create an order. Use this to create a contract sale or report line items of insurable products for later sales. First parameter is your internal ID for the order; second is an associative array with the parameters of your order. Please see our [documentation](https://api.joinclyde.com/docs) for available options.

```php
$order = $clyde.createOrder($id, $orderOpts);
```

### Get Order

Get an order that has already been placed. The order ID from your system is the first and only parameter.

```php
$order = $clyde.getOrder($id);
```

### Cancel Order

Cancel an order you have already placed. Use this to cancel all contract sales, or generally remove from our system all line items associated with an order. The order ID from your system is the first and only parameter.

```php
$order = $clyde.cancelOrder($id);
```

### Get Contract Sale

Get a previously sold contract sale. The ID returned from the original sale is the first and only parameter.

```php
$contractSale = $clyde.getContractSale($clydeId);
```

### Cancel Contract Sale

Cancel a previously sold contract sale. The ID returned from the original sale is the first and only parameter.

```php
$contractSale = $clyde.cancelContractSale($clydeId);
```


## Error Handling

When an error occurs `clyde-sdk` will throw that error. Use `try / catch` to handle errors.

```php
try {
  $newProduct = $clyde.createProduct($productOptions);
} catch(Exception $e) {
  // Handle the exception
}
```


## License
MIT