<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class AuthenticationTest extends ApiTestCase
{
    public function testSuccessfulLogin(): void
    {
        $email = 'admin@api.com';
        $password = 'password';

        $response = static::createClient()->request('POST', '/auth', [
            'json' => [
                'username' => $email,
                'password' => $password,
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = $response->toArray();
        $this->assertArrayHasKey('token', $data);

        $token = $data['token'];
        $client = static::createClient();
        $client->request('GET', '/api/favorites', [
            'headers' => ['Authorization' => 'Bearer '.$token],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testInvalidLogin(): void
    {
        $response = static::createClient()->request('POST', '/api/auth', [
            'json' => [
                'username' => 'admin@api.com',
                'password' => 'wrong_password',
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }
}
