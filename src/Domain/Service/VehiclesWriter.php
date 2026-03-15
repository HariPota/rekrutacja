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
            $this->vehicleRepository->beginTransaction();

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
            $this->vehicleRepository->commit();
        } catch (\Throwable $e) {
            $this->vehicleRepository->rollback();
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
            $this->vehicleRepository->beginTransaction();

            $vehicle = $this->vehicleRepository->getById($id);

            if (!$vehicle) {
                $this->vehicleRepository->rollback();
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
            $this->vehicleRepository->commit();
        } catch (\RuntimeException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->vehicleRepository->rollback();
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
            $this->vehicleRepository->beginTransaction();
            $this->vehicleRepository->deleteById($id);
            $this->vehicleRepository->commit();
        } catch (\Throwable $e) {
            $this->vehicleRepository->rollback();
            throw new \RuntimeException('Failed to delete vehicle: ' . $e->getMessage(), 0, $e);
        }
    }
}
