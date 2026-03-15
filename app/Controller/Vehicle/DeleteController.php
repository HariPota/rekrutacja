<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesWriter;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends BaseController
{
    /**
     * @param int|null $id
     * @param Request|null $request
     * @return JsonResponse
     */
    public function delete(?int $id = null, ?Request $request = null): JsonResponse
    {
        if (!$id) {
            return $this->toJsonResponse(['success' => false, 'message' => 'Missing vehicle ID'], 400);
        }

        try {
            (new VehiclesWriter(new VehicleRepository()))->deleteById($id);

            return $this->toJsonResponse(['success' => true]);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
