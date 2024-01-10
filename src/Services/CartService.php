<?php namespace App\Services;

use App\Entities\Customer;
use App\Exceptions\ProductQuantityTooLowException;
use App\Interfaces\ICartService;
use App\Entities\Product;

class CartService implements ICartService
{
    public function __construct(
        protected Customer $customer,
        protected array $offers = [],
        protected array $items = [],
        protected float $cartValue = 0.00
    ) {
        foreach($offers as $offer)
        {
            if (!$offer->validate($customer))
            {
                throw new \App\Exceptions\CustomerIneligibleForOffer(
                    "customer is not eligible for this offer. Minimum plan length must be: " . $offer->getPlanLength()
                );
            }
        }
    }

    public function addProduct(Product $product, int $quantity): void {

        if ($quantity <=0) {
            throw new ProductQuantityTooLowException(
                "Quantity must be more than 0."
            );
        }

        if ($quantity > 1) {
            throw new \App\Exceptions\ProductQuantityTooHighException(
                "Quantity cannot be more than 1."
            );
        }

        $this->items[$product->getProductCode()] = $quantity;
        $this->cartValue += $product->getProductPrice();
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCartValue(): float
    {
        $valueToReturn = $this->cartValue;

        foreach ($this->offers as $offer)
        {
            // Offers will already be validated in construct - we just apply them here
            $valueToReturn = $offer->apply($valueToReturn);
        }

        return $valueToReturn;
    }

    public function getOffers(): array
    {
        return $this->offers;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}