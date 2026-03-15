<?php

namespace Domain\Enum;

enum VehicleTypeEnum: string
{
    case PASSENGER = 'Passenger';
    case BUS = 'Bus';
    case TRUCK = 'Truck';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }
}
