<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesReader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @param VehiclesReader $vehiclesReader
     */
    public function __construct(private readonly VehiclesReader $vehiclesReader)
    {
        parent::__construct();
    }

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
            $results = $this->vehiclesReader->getList($limit, $offset, $sort, $sortDirection);

            return $this->toJsonResponse($results);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => 'An error occurred while fetching vehicles'], 500);
        }
    }
}
