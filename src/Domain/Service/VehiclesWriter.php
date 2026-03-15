<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
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
    public function createVehicle(VehicleDTO $vehicleDTO): void
    {
        try {
            $now = time();

            $vehicle = new Vehicle(
                registrationNumber: $vehicleDTO->registrationNumber,
                brand: $vehicleDTO->brand,
                model: $vehicleDTO->model,
                type: $vehicleDTO->type,
                createdAt: $now,
                updatedAt: $now,
            );

            $this->vehicleRepository->persist($vehicle);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to create vehicle: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @param int $id
     * @param VehicleDTO $vehicleDTO
     * @return void
     * @throws \RuntimeException
     */
    public function updateVehicle(int $id, VehicleDTO $vehicleDTO): void
    {
        try {
            $vehicle = $this->vehicleRepository->getById($id);

            if (!$vehicle) {
                throw new \RuntimeException('Vehicle not found');
            }

            $vehicle->update(
                registrationNumber: $vehicleDTO->registrationNumber,
                brand: $vehicleDTO->brand,
                model: $vehicleDTO->model,
                type: $vehicleDTO->type,
                updatedAt: time(),
            );

            $this->vehicleRepository->persist($vehicle);
        } catch (\RuntimeException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to update vehicle: ' . $e->getMessage(), 0, $e);
        }
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
