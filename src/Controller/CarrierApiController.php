<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Request\Carrier\CarrierRequest;
use App\DTO\Request\Carrier\CarrierUpdate;
use App\UseCase\Carrier\CarrierUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/carrier')]
class CarrierApiController extends AbstractController
{
    public function __construct(
        private readonly CarrierUseCase $carrierUseCase
    ) {}

    #[Route('', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] CarrierRequest $carrierRequest
    ): JsonResponse
    {
        try {
            $response = $this->carrierUseCase->create($carrierRequest);

            return $this->json($response, JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }


    #[Route('', methods: ['GET'])]
    public function listAll(): JsonResponse
    {
        $carriers = $this->carrierUseCase->listAll();

        return $this->json($carriers);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        $carrier = $this->carrierUseCase->getById($id);

        if (!$carrier) {
            return $this->json(['error' => 'Carrier not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($carrier);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] CarrierUpdate $carrierUpdate): JsonResponse
    {
        try {
            $response = $this->carrierUseCase->update($id, $carrierUpdate);
            return $this->json($response);
        } catch (\Exception $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}