<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use App\ParamConverter\ParamConverterInterface;
use App\Request\SaveVehicleRequest;
use Domain\Service\VehicleDTO;
use Domain\Service\VehiclesWriter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends BaseController
{
    /**
     * @param VehiclesWriter $vehiclesWriter
     * @param ParamConverterInterface $paramConverter
     */
    public function __construct(
        private readonly VehiclesWriter $vehiclesWriter,
        private readonly ParamConverterInterface $paramConverter,
    ) {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            /** @var SaveVehicleRequest $saveRequest */
            $saveRequest = $this->paramConverter->convert($request, SaveVehicleRequest::class);

            $errors = $this->validate($saveRequest);
            if ($errors->count()) {
                return $this->toJsonResponse(['success' => false, 'message' => $errors->get(0)->getMessage()], 400);
            }

            $vehicleDTO = new VehicleDTO(
                id: null,
                registrationNumber: $saveRequest->registrationNumber,
                brand: $saveRequest->brand,
                model: $saveRequest->model,
                type: $saveRequest->type,
                createdAt: null,
                updatedAt: null,
            );

            $this->vehiclesWriter->createVehicle($vehicleDTO);

            return $this->toJsonResponse(['success' => true]);
        } catch (\InvalidArgumentException $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => 'An error occurred while creating the vehicle'], 500);
        }
    }
}
