<?php

namespace Domain\Repository;

use Domain\Entity\Carrier;

interface CarrierRepositoryInterface
{
    public function save(Carrier $carrier): Carrier;
    public function findById(int $id): ?Carrier;
    public function findAll(): array;
    public function delete(int $id): void;
    public function update(Carrier $carrier): Carrier;
}