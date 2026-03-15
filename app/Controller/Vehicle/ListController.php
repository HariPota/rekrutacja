<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesReader;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $offset = ($page - 1) * $limit;

        $sort = 'createdAt';
        $sortDirection = 'desc';
        $sortParam = $request->query->get('sort');

        if ($sortParam) {
            $parts = explode('|', $sortParam);
            $sort = $parts[0];
            if (isset($parts[1])) {
                $sortDirection = in_array($parts[1], ['ascending', 'asc']) ? 'asc' : 'desc';
            }
        }

        try {
            $results = (new VehiclesReader(new VehicleRepository()))->getList($limit, $offset, $sort, $sortDirection);

            return $this->toJsonResponse($results);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
