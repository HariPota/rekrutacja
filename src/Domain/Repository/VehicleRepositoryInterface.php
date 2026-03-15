<?php

namespace Domain\Repository;

use Domain\Entity\Vehicle;

interface VehicleRepositoryInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @param string|null $sort
     * @param string $sortDirection
     * @return Vehicle[]
     */
    public function getList(int $limit = 10, int $offset = 0, ?string $sort = null, string $sortDirection = 'asc'): array;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @param int $id
     * @return Vehicle|null
     */
    public function getById(int $id): ?Vehicle;

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * @param Vehicle $vehicle
     * @return void
     */
    public function persist(Vehicle $vehicle): void;

    /**
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * @return void
     */
    public function commit(): void;

    /**
     * @return void
     */
    public function rollback(): void;
}
