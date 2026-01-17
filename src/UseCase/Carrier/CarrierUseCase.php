<?php

namespace App\UseCase\Carrier;

use App\DTO\Request\Carrier\CarrierRequest;
use App\DTO\Request\Carrier\CarrierUpdate;
use App\DTO\Response\Carrier\CarrierResponse;
use Domain\Repository\CarrierRepositoryInterface;
use Domain\Entity\Carrier;
use Domain\Enum\StatusEnum;
use DateTime;

class CarrierUseCase
{
    public function __construct(
        private readonly CarrierRepositoryInterface $carrierRepository
    ) {}

    public function create(CarrierRequest $request): CarrierResponse
    {
        $carrier = new Carrier(
            id: null,
            name: $request->name,
            document: $request->document,
            status: StatusEnum::from($request->status),
            createdAt: new DateTime()
        );

        $savedCarrier = $this->carrierRepository->save($carrier);

        return new CarrierResponse(
            id: $savedCarrier->getId(),
            name: $savedCarrier->getName(),
            document: $savedCarrier->getDocument(),
            status: $savedCarrier->getStatus()->value,
            createdAt: $savedCarrier->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function listAll(): array
    {
        $carriers = $this->carrierRepository->findAll();
        $responses = [];

        foreach ($carriers as $carrier) {
            $responses[] = new CarrierResponse(
                id: $carrier->getId(),
                name: $carrier->getName(),
                document: $carrier->getDocument(),
                status: $carrier->getStatus()->value,
                createdAt: $carrier->getCreatedAt()->format('Y-m-d H:i:s')
            );
        }

        return $responses;
    }

    public function getById(int $id): ?CarrierResponse
    {
        $carrier = $this->carrierRepository->findById($id);

        if (!$carrier) {
            return null;
        }

        return new CarrierResponse(
            id: $carrier->getId(),
            name: $carrier->getName(),
            document: $carrier->getDocument(),
            status: $carrier->getStatus()->value,
            createdAt: $carrier->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function update(int $id, CarrierUpdate $request): CarrierResponse
    {
        $existingCarrier = $this->carrierRepository->findById($id);

        if (!$existingCarrier) {
            throw new \Exception("Carrier not found.");
        }

        $request = new Carrier(
            id: $existingCarrier->getId(),
            name: $request->name ?? $existingCarrier->getName(),
            document: $request->document ?? $existingCarrier->getDocument(),
            status: $request->status ? StatusEnum::from($request->status) : $existingCarrier->getStatus(),
            createdAt: $existingCarrier->getCreatedAt()
        );

        $savedCarrier = $this->carrierRepository->update($request);

        return new CarrierResponse(
            id: $savedCarrier->getId(),
            name: $savedCarrier->getName(),
            document: $savedCarrier->getDocument(),
            status: $savedCarrier->getStatus()->value,
            createdAt: $savedCarrier->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }
}