<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};

class SaveController extends BaseController
{
    public function save(int $id, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        return $this->toJsonResponse([$id, $content]);
    }
}
