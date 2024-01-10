<?php namespace App\ValueObjects;
      use App\Entities\Customer;

class Offer {
    public function __construct(
        protected string $percentage,
        protected int $planLength = 12
    ) {}

    public function validate(Customer $customer): bool
    {
        return $customer->getPlanLength() >= $this->planLength;
    }

    public function apply(float $value): float
    {
        $multiplier = 1 - (floatval($this->percentage) / 100);
        return $value * $multiplier;
    }

    public function getPlanLength(): int
    {
        return $this->planLength;
    }
}