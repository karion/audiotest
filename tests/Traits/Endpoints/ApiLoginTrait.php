<?php

namespace Tests\Traits\Endpoints;


trait ApiLoginTrait
{
    protected function getUserToken(): string
    {
        $data = [
            'username' => 'user@karion.net.pl',
            'password' => 'password1'
        ];

        return $this->getToken($data);
    }

    protected function getAdminToken(): string
    {
        $data = [
            'username' => 'admin@karion.net.pl',
            'password' => 'password1'
        ];

        return $this->getToken($data);
    }

    protected function getToken(array $data): string
    {
        $response = self::$client->post(
            '/api/login_check',
            [
                'body' => json_encode($data)
            ]
        );

        return $this->getParsedBody($response)['token'];
    }
}