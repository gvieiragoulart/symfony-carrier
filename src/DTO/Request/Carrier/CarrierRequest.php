<?php

namespace App\DTO\Request\Carrier;

use Symfony\Component\Validator\Constraints as Assert;

class CarrierRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required')]
        #[Assert\Length(min: 3, max: 255)]
        public readonly string $name,

        #[Assert\NotBlank(message: 'Document is required')]
        #[Assert\Length(min: 11, max: 14)]
        public readonly string $document,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: ['active', 'inactive'])]
        public readonly string $status,
    ) {}
}