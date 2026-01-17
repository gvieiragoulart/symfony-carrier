<?php

namespace App\DTO\Response\Carrier;

class CarrierResponse
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $document,
        public readonly string $status,
        public readonly string $createdAt
    ) {}
}