<?php

namespace Domain\Service;

use Domain\Repository\VehicleRepositoryInterface;

class VehiclesWriter
{
    /**
     * @param VehicleRepositoryInterface $vehicleRepository
     */
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    /**
     * @param VehicleDTO $vehicleDTO
     * @return void
     * @throws \RuntimeException
     */
    public function saveVehicle(VehicleDTO $vehicleDTO): void
    {
    }

    /**
     * @param int $id
     * @return void
     * @throws \RuntimeException
     */
    public function deleteById(int $id): void
    {
        try {
            $this->vehicleRepository->deleteById($id);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to delete vehicle: ' . $e->getMessage(), 0, $e);
        }
    }
}
