<?php

namespace Domain\Entity;

use DateTime;
use Domain\Enum\StatusEnum;
use InvalidArgumentException;

class Carrier {
    private $id;
    private string $name;
    private string $document;
    private StatusEnum $status;
    private DateTime $createdAt;

    public function __construct(
        ?int $id,
        string $name,
        string $document,
        StatusEnum $status,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->document = $document;
        $this->status = $status;
        $this->createdAt = $createdAt;

        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException("Name cannot be empty.");
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}