<?php namespace App\Entities;

class Customer
{
    public function __construct(
        protected int $id,
        protected string $name,
        protected int $planLength
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlanLength(): int
    {
        return $this->planLength;
    }
}