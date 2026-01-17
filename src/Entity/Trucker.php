<?php

namespace App\Entity;

use App\Repository\TruckerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TruckerRepository::class)]
class Trucker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Carrier>
     */
    #[ORM\ManyToMany(targetEntity: Carrier::class, inversedBy: 'truckers')]
    private Collection $carrierId;

    public function __construct()
    {
        $this->carrierId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Carrier>
     */
    public function getCarrierId(): Collection
    {
        return $this->carrierId;
    }

    public function addCarrierId(Carrier $carrierId): static
    {
        if (!$this->carrierId->contains($carrierId)) {
            $this->carrierId->add($carrierId);
        }

        return $this;
    }

    public function removeCarrierId(Carrier $carrierId): static
    {
        $this->carrierId->removeElement($carrierId);

        return $this;
    }
}
