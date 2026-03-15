<?php

namespace Domain\Entity;

class Vehicle
{
    /**
     * @param int $id
     * @param string $registrationNumber
     * @param string $brand
     * @param string $model
     * @param string $type
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(
        private readonly int $id = 0,
        private readonly string $registrationNumber = '',
        private readonly string $brand = '',
        private readonly string $model = '',
        private readonly string $type = '',
        private readonly ?int $createdAt = null,
        private readonly ?int $updatedAt = null,
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @return int|null
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }
}
