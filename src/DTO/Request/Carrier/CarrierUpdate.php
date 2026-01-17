<?php

namespace App\DTO\Request\Carrier;

use Symfony\Component\Validator\Constraints as Assert;

class CarrierUpdate
{
    public function __construct(
        
        #[Assert\Length(min: 3, max: 255)]
        public readonly ?string $name,

        #[Assert\Length(min: 11, max: 14)]
        public readonly ?string $document,

        #[Assert\Choice(choices: ['active', 'inactive'])]
        public readonly ?string $status,
    ) {}
}