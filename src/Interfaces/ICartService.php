<?php namespace App\Interfaces;

use App\Entities\Product;
use App\Entities\Customer;

interface ICartService
{
    /**
     * @return void
     */
    public function addProduct(Product $product, int $quantity): void;

    /**
     * @return float
     */
    public function getCartValue(): float;

    /**
     * @return array<string>int
     */
    public function getItems(): array;

    /**
     * @return array<\App\ValueObjects\Offer>
     */
    public function getOffers(): array;

    /**
     * @return \App\Entities\Customer
     */
    public function getCustomer(): Customer;
}