<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesBuilder
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
     */
    public function getList(int $limit = 10, int $offset = 0, ?string $sort = null, string $sortDirection = 'asc'): array
    {
        $items = $this->vehicleRepository->getList($limit, $offset, $sort, $sortDirection);
        $total = $this->vehicleRepository->getCount();

        return [
            'rows' => array_map([$this, 'entityToDTO'], $items),
            'total' => $total,
        ];
    }

    /**
     * @param Vehicle $vehicle
     * @return VehicleDTO
     */
    private function entityToDTO(Vehicle $vehicle): VehicleDTO
    {
        $vehicleDTO = new VehicleDTO();
        $vehicleDTO->id = $vehicle->getId();
        $vehicleDTO->registrationNumber = $vehicle->getRegistrationNumber();
        $vehicleDTO->brand = $vehicle->getBrand();
        $vehicleDTO->model = $vehicle->getModel();
        $vehicleDTO->type = $vehicle->getType();
        $vehicleDTO->createdAt = $vehicle->getCreatedAt();
        $vehicleDTO->updatedAt = $vehicle->getUpdatedAt();

        return $vehicleDTO;
    }
}
