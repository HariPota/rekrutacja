<?php

namespace Domain\Entity;

use JMS\Serializer\Annotation as Serializer;

class Vehicle implements \JsonSerializable
{
    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("id")
     */
    private ?int $id = null;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("registration_number")
     */
    private string $registrationNumber;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("brand")
     */
    private string $brand;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("model")
     */
    private string $model;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("type")
     */
    private string $type;

    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("created_at")
     */
    private ?int $createdAt;

    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("updated_at")
     */
    private ?int $updatedAt;

    /**
     * @param string $registrationNumber
     * @param string $brand
     * @param string $model
     * @param string $type
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(
        string $registrationNumber,
        string $brand,
        string $model,
        string $type,
        ?int $createdAt = null,
        ?int $updatedAt = null,
    ) {
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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

    /**
     * @param string $registrationNumber
     * @param string $brand
     * @param string $model
     * @param string $type
     * @param int|null $updatedAt
     * @return void
     */
    public function update(
        string $registrationNumber,
        string $brand,
        string $model,
        string $type,
        ?int $updatedAt = null,
    ): void {
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
        $this->type = $type;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'registrationNumber' => $this->registrationNumber,
            'brand' => $this->brand,
            'model' => $this->model,
            'type' => $this->type,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
