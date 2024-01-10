<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Entities\Product;
use App\Services\CartService;
use App\ValueObjects\Offer;
use App\Entities\Customer;

final class CartTest extends TestCase
{
    public function testCanInitialiseBasketWithOffers(): void
    {
        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
            [
                new Offer('10'),
            ]
        );

        $this->assertEquals("Jack", $cart->getCustomer()->getName());
        $this->assertEquals(1, $cart->getCustomer()->getId());
        $this->assertCount(1, $cart->getOffers());
    }

    public function testCantInitialiseWithIneligibleOffers(): void
    {
        $this->expectException(\App\Exceptions\CustomerIneligibleForOffer::class);

        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
            [
                new Offer('24', 24),
            ]
        );
    }

    public function testCartCanOnlyHaveOneProductQuantity(): void 
    {
        $this->expectException(\App\Exceptions\ProductQuantityTooHighException::class);

        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
        );
        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, 2);
    }

    public function testProductQuantityCannontBeZero(): void
    {
        $this->expectException(\App\Exceptions\ProductQuantityTooLowException::class);

        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
        );
        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, 0);
    }

    public function testProductQuantityCannotBeLessThanZero(): void
    {
        $this->expectException(\App\Exceptions\ProductQuantityTooLowException::class);

        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
        );
        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, -1);
    }

    public function testCartCanAddProduct(): void 
    {
        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
        );
        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, 1);

        $this->assertEquals("Photography", $product->getProductName());
        $this->assertCount(1, $cart->getItems());
        $this->assertArrayHasKey($product->getProductCode(), $cart->getItems());
    }

    public function testCartTotalIsCorrectWithoutOffers(): void
    {
        $cart = new CartService(
            new Customer(
                1,
                "Jack",
                12
            ),
        );
        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, 1);
        $this->assertEquals(200, $cart->getCartValue());
    }

    public function testCartTotalIsCorrectWithOffers(): void
    {
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

        $product = new Product(
            "P001",
            "Photography",
            200,
        );
        $cart->addProduct($product, 1);
        $this->assertEquals(180, $cart->getCartValue());
    }

    public function testCartIsCorrectWithMultipleProductsAndOffer(): void
    {
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

        $product = new Product(
            "P001",
            "Photography",
            200,
        );

        $cart->addProduct($product, 1);

        $product2 = new Product(
            "P003",
            "Gas Certificate",
            83.50,
        );

        $cart->addProduct($product2, 1);

        $this->assertEquals(255.15, $cart->getCartValue());
    }
}