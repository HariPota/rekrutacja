<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesReader
{
    /**
     * @param VehicleRepositoryInterface $vehicleRepository
     */
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string|null $sort
     * @param string $sortDirection
     * @return array{rows: Vehicle[], total: int}
     * @throws \RuntimeException
     */
    public function getList(int $limit = 10, int $offset = 0, ?string $sort = null, string $sortDirection = 'asc'): array
    {
        try {
            return [
                'rows' => $this->vehicleRepository->getList($limit, $offset, $sort, $sortDirection),
                'total' => $this->vehicleRepository->getCount(),
            ];
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to fetch vehicles list: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @return Vehicle[]
     * @throws \RuntimeException
     */
    public function getAll(): array
    {
        try {
            return $this->vehicleRepository->getList(PHP_INT_MAX, 0, 'createdAt', 'desc');
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to fetch vehicles: ' . $e->getMessage(), 0, $e);
        }
    }
}
