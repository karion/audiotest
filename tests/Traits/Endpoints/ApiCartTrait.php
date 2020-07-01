<?php

namespace Tests\Traits\Endpoints;

use Symfony\Component\HttpFoundation\Response;
use Tests\ApiModel\CartApiModel;
use Tests\ApiModel\ProductApiModel;

trait ApiCartTrait
{
    protected function cartCreate(
        array $data = [],
        ?string $token = null,
        int $expectedStatusCode = Response::HTTP_CREATED,
        array $expectedValues = []
    ): array {
        $response = self::$client->post(
            '/api/carts',
            [
                'headers' => $this->buildHeaders($token),
                'body' => json_encode($data)
            ]
        );

        return $this->handleValidation($response, CartApiModel::class, $expectedStatusCode, $expectedValues);
    }

    protected function cartAddProduct(
        string $cartId,
        string $productId,
        ?string $token = null,
        int $expectedStatusCode = Response::HTTP_CREATED,
        array $expectedValues = []
    ): array {
        $response = self::$client->post(
            sprintf(
                '/api/carts/%s/products/%s',
                $cartId,
                $productId
            ),
            [
                'headers' => $this->buildHeaders($token)
            ]
        );

        return $this->handleValidation($response, CartApiModel::class, $expectedStatusCode, $expectedValues);
    }

}