<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesWriter;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteController extends BaseController
{
    /**
     * @param VehiclesWriter $vehiclesWriter
     */
    public function __construct(private readonly VehiclesWriter $vehiclesWriter)
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->vehiclesWriter->deleteById($id);

            return $this->toJsonResponse(['success' => true]);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => 'An error occurred while deleting the vehicle'], 500);
        }
    }
}
