<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use App\ParamConverter\JsonParamConverter;
use App\Request\SaveVehicleRequest;
use Domain\Service\VehicleDTO;
use Domain\Service\VehiclesWriter;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends BaseController
{
    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        try {
            /** @var SaveVehicleRequest $saveRequest */
            $saveRequest = (new JsonParamConverter())->convert($request, SaveVehicleRequest::class);

            $errors = $this->validate($saveRequest);
            if ($errors->count()) {
                return $this->toJsonResponse(['success' => false, 'message' => $errors->get(0)->getMessage()], 400);
            }

            $vehicleDTO = new VehicleDTO(
                id: $id,
                registrationNumber: $saveRequest->registrationNumber,
                brand: $saveRequest->brand,
                model: $saveRequest->model,
                type: $saveRequest->type,
                createdAt: null,
                updatedAt: null,
            );

            (new VehiclesWriter(new VehicleRepository()))->updateVehicle($id, $vehicleDTO);

            return $this->toJsonResponse(['success' => true]);
        } catch (\InvalidArgumentException $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => 'An error occurred while updating the vehicle'], 500);
        }
    }
}
