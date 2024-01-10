<?php namespace App\Entities;

class Product
{
    public function __construct(
        protected string $productCode,
        protected string $productName,
        protected float $productPrice,
    )
    {}

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductPrice(): float
    {
        return $this->productPrice;
    }
}