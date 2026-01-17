<?php

namespace App\Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use DateTime;
use Domain\Enum\StatusEnum;
use Domain\Entity\Carrier;
use InvalidArgumentException;

class CarrierTest extends TestCase
{
    public function testCarrierCreation(): void
    {
        $id = 1;
        $name = "Carrier Name";
        $document = "123456789";
        $status = StatusEnum::ACTIVE;
        $createdAt = new DateTime();

        $carrier = new Carrier($id, $name, $document, $status, $createdAt);

        $this->assertEquals($id, $carrier->getId());
        $this->assertEquals($name, $carrier->getName());
        $this->assertEquals($document, $carrier->getDocument());
        $this->assertEquals($status, $carrier->getStatus());
        $this->assertEquals($createdAt, $carrier->getCreatedAt());
    }

    public function testCarrierInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Carrier(1, "", "123456789", StatusEnum::ACTIVE, new DateTime());
    }
}