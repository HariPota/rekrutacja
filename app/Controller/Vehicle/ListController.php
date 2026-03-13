<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesBuilder;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListController extends BaseController
{
    public function list(): JsonResponse
    {
        $results = (new VehiclesBuilder(new VehicleRepository()))->getList();

        return $this->toJsonResponse(['results' => $results]);
    }
}
