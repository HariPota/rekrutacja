<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesWriter;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteController extends BaseController
{
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            (new VehiclesWriter(new VehicleRepository()))->deleteById($id);

            return $this->toJsonResponse(['success' => true]);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
