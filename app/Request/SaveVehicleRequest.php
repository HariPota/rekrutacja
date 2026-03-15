<?php

namespace App\Request;

use Domain\Enum\VehicleTypeEnum;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class SaveVehicleRequest
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("registrationNumber")
     */
    #[Assert\NotBlank(message: 'Registration number is required')]
    public string $registrationNumber = '';

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("brand")
     */
    #[Assert\NotBlank(message: 'Brand is required')]
    public string $brand = '';

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("model")
     */
    #[Assert\NotBlank(message: 'Model is required')]
    public string $model = '';

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("type")
     */
    #[Assert\NotBlank(message: 'Vehicle type is required')]
    #[Assert\Choice(callback: [VehicleTypeEnum::class, 'values'], message: 'Vehicle type must be one of: Passenger, Bus, Truck')]
    public string $type = '';
}
