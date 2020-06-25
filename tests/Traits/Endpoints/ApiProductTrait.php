<?php

namespace Tests\Traits\Endpoints;

use Symfony\Component\HttpFoundation\Response;
use Tests\ApiModel\ProductApiModel;

trait ApiProductTrait
{
     protected function productList(
        array $filters = [],
        ?string $token = null,
        int $expectedStatusCode = Response::HTTP_OK,
        array $expectedValues = []
    ): array {
        $uri = '/api/products';

        if (!empty($filters)) {
            $uri .= '?' . http_build_query($filters);
        }

        $response = self::$client->get(
            $uri,
            ['headers' => $this->buildHeaders($token)]
        );

        return $this->handleValidation($response, ProductApiModel::class . '[]', $expectedStatusCode, $expectedValues);
    }

}