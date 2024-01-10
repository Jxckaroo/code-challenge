<?php

ini_set("display_errors", 1);

use App\Entities\Customer;
use App\Entities\Product;
use App\Services\CartService;
use App\ValueObjects\Offer;

/**
 * Example of the code working.
 * See README.md for instructions on running the tests.
 */

require_once '../vendor/autoload.php';

// Initialise cart
$cart = new CartService(
    new Customer(
        1,
        "Jack",
        12
    ),
    [
        new Offer("10")
    ]
);

// Create product database
$products = [
    "P001" => new Product(
        "P001",
        "Photography",
        200,
    ),
    "P002" => new Product(
        "P002",
        "Floorplan",
        100,
    ),
    "P003" => new Product(
        "P003",
        "Gas Certificate",
        83.50,
    ),
    "P004" => new Product(
        "P004",
        "EICR Certificate",
        51.00,
    ),
];

foreach ($products as $product)
{
    $cart->addProduct($product, 1);
}


$lineLength = 65;
$totalValue = 0.00;
foreach($cart->getItems() as $itemCode => $quantity)
{
    foreach ($products as $productCode => $product) {
        if ($productCode == $itemCode) {
            $totalValue += $product->getProductPrice();
            echo $product->getProductName() . ': &pound;' . $product->getProductPrice() . '<br/>';
        }
    }
}

echo "Total: &pound;" . number_format($totalValue, 2) . "<br/>";
echo "Total with discount of 10%: &pound;" . $cart->getCartValue();