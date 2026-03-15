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
     * @return array{rows: VehicleDTO[], total: int}
     * @throws \RuntimeException
     */
    public function getList(int $limit = 10, int $offset = 0, ?string $sort = null, string $sortDirection = 'asc'): array
    {
        try {
            $items = $this->vehicleRepository->getList($limit, $offset, $sort, $sortDirection);
            $total = $this->vehicleRepository->getCount();

            return [
                'rows' => array_map([$this, 'entityToDTO'], $items),
                'total' => $total,
            ];
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to fetch vehicles list: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @param int $id
     * @return VehicleDTO|null
     * @throws \RuntimeException
     */
    public function getVehicleById(int $id): ?VehicleDTO
    {
        try {
            $vehicle = $this->vehicleRepository->getById($id);

            return $vehicle ? $this->entityToDTO($vehicle) : null;
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to fetch vehicle: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @param Vehicle $vehicle
     * @return VehicleDTO
     */
    private function entityToDTO(Vehicle $vehicle): VehicleDTO
    {
        return new VehicleDTO(
            id: $vehicle->getId(),
            registrationNumber: $vehicle->getRegistrationNumber(),
            brand: $vehicle->getBrand(),
            model: $vehicle->getModel(),
            type: $vehicle->getType(),
            createdAt: $vehicle->getCreatedAt(),
            updatedAt: $vehicle->getUpdatedAt(),
        );
    }
}
