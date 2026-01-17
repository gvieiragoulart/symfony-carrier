<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
#[ORM\Table(name: 'carrier')]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 14)]
    private string $document;

    #[ORM\Column(length: 20)]
    private string $status;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, Trucker>
     */
    #[ORM\ManyToMany(targetEntity: Trucker::class, mappedBy: 'carrierId')]
    private Collection $truckers;

    public function __construct()
    {
        $this->truckers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): static
    {
        $this->document = $document;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection<int, Trucker>
     */
    public function getTruckers(): Collection
    {
        return $this->truckers;
    }

    public function addTrucker(Trucker $trucker): static
    {
        if (!$this->truckers->contains($trucker)) {
            $this->truckers->add($trucker);
            $trucker->addCarrierId($this);
        }

        return $this;
    }

    public function removeTrucker(Trucker $trucker): static
    {
        if ($this->truckers->removeElement($trucker)) {
            $trucker->removeCarrierId($this);
        }

        return $this;
    }
}