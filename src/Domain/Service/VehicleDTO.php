<?php

namespace Domain\Service;

class VehicleDTO
{
    /**
     * @param int|null $id
     * @param string $registrationNumber
     * @param string $brand
     * @param string $model
     * @param string $type
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(
        public readonly ?int $id,
        public readonly string $registrationNumber,
        public readonly string $brand,
        public readonly string $model,
        public readonly string $type,
        public readonly ?int $createdAt,
        public readonly ?int $updatedAt,
    ) {
    }
}
