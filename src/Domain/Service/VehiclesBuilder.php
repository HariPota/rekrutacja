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
}
