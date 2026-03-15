<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
    }

    /**
     * @param object $request
     * @return ConstraintViolationListInterface
     */
    protected function validate(object $request): ConstraintViolationListInterface
    {
        return $this->validator->validate($request);
    }

    /**
     * @param array $response
     * @param int $status
     * @return JsonResponse
     */
    protected function toJsonResponse(array $response, int $status = 200): JsonResponse
    {
        return (new JsonResponse($response, $status))->send();
    }
}
