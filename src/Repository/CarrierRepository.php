<?php

namespace App\Repository;

use App\Entity\Carrier as CarrierEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Entity\Carrier;
use Domain\Enum\StatusEnum;
use Domain\Repository\CarrierRepositoryInterface;

class CarrierRepository extends ServiceEntityRepository implements CarrierRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrierEntity::class);
    }

    public function save(Carrier $carrier): Carrier
    {
        $entity = new CarrierEntity();
        $entity->setName($carrier->getName());
        $entity->setDocument($carrier->getDocument());
        $entity->setStatus($carrier->getStatus()->value);
        $entity->setCreatedAt(\DateTimeImmutable::createFromMutable($carrier->getCreatedAt()));

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return new Carrier(
            id: $entity->getId(),
            name: $entity->getName(),
            document: $entity->getDocument(),
            status: StatusEnum::from($entity->getStatus()),
            createdAt: \DateTime::createFromImmutable($entity->getCreatedAt())
        );
    }

    public function findById(int $id): ?Carrier
    {
        $entity = $this->find($id);
        
        if (!$entity) {
            return null;
        }

        return new Carrier(
            id: $entity->getId(),
            name: $entity->getName(),
            document: $entity->getDocument(),
            status: StatusEnum::from($entity->getStatus()),
            createdAt: \DateTime::createFromImmutable($entity->getCreatedAt())
        );
    }

    public function findAll(): array
    {
        $entities = parent::findAll();
        
        return array_map(fn(CarrierEntity $entity) => new Carrier(
            id: $entity->getId(),
            name: $entity->getName(),
            document: $entity->getDocument(),
            status: StatusEnum::from($entity->getStatus()),
            createdAt: \DateTime::createFromImmutable($entity->getCreatedAt())
        ), $entities);
    }

    public function delete(int $id): void
    {
        $entity = $this->find($id);
        
        if ($entity) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    public function update(Carrier $carrier): Carrier
    {
        $entity = $this->find($carrier->getId());
        
        if (!$entity) {
            throw new \InvalidArgumentException("Carrier not found.");
        }

        $entity->setName($carrier->getName());
        $entity->setDocument($carrier->getDocument());
        $entity->setStatus($carrier->getStatus()->value);

        $this->getEntityManager()->flush();

        return new Carrier(
            id: $entity->getId(),
            name: $entity->getName(),
            document: $entity->getDocument(),
            status: StatusEnum::from($entity->getStatus()),
            createdAt: \DateTime::createFromImmutable($entity->getCreatedAt())
        );
    }
}