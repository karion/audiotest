<?php

declare(strict_types=1);

namespace Tests\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

trait ResponseHandlerTrait
{
    use ApiModelValidatorTrait;

    /** @var Client $client  */
    protected static $client;

    public static function setupClient(string $email = null): void
    {
        $base = $_SERVER['API_BASE_URI'] ?? 'http://localhost';

        self::$client = new Client([
            'base_uri' => $base,
            'exceptions' => false,
            'verify' => false,// ssl
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function getParsedBody(ResponseInterface $response): array
    {
        $json = (array)json_decode((string)$response->getBody(), true);

        return $json;
    }

    protected function buildHeaders(string $token = null): array
    {
        $headers = [];

        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    protected function handleValidation(
        ResponseInterface $response,
        string $model,
        int $expectedStatusCode,
        array $expectedValue = []
    ): array {
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if (!in_array($expectedStatusCode, [Response::HTTP_OK, Response::HTTP_CREATED])) {
            return [];
        }

        $body = $this->getParsedBody($response);

        $this->responseAssertions($body, $expectedValue, $model);

        return $body;
    }
}