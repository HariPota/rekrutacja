<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteController extends BaseController
{
    public function delete(int $id): JsonResponse
    {
        return $this->toJsonResponse([$id]);
    }
}
