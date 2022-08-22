<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


use Symfony\Component\HttpFoundation\Response;

use Faker\Factory;
use Faker\Generator;

use App\Utils\UserUtils;

class RegistrationControllerTest extends WebTestCase
{ 

    public function testRegisterWithoutJsonResponse(): void
    {
        $faker = Factory::create();
        
        $client = static::createClient();

        $client->request('POST', '/register', [
            'email'    => $faker->email(),
            'password' => $faker->password()
        ]);
 
        $response = $client->getResponse(); 

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode()); // 201

        $this->assertJsonStringEqualsJsonString(
            json_encode(array("message" => UserUtils::SUCCESS_USER_CREATE)),
            $response->getContent()
        );
    }

    
    public function testRegisterWithoutEmailFail(): void
    {
        $faker = Factory::create();
        $client = static::createClient();

        $client->request('POST', '/register', [
            'email'    => "",
            'password' => $faker->password()
        ]);
 
        $response = $client->getResponse(); 

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode()); // 400

        $this->assertJsonStringEqualsJsonString(
            json_encode(array("error" => UserUtils::ERROR_EMAIL)),
            $response->getContent()
        );
    }

    public function testRegisterWithoutPasswordFail(): void
    {
        $faker = Factory::create();
        $client = static::createClient();

        $client->request('POST', '/register', [
            'email'    => $faker->email(),
            'password' => ""
        ]);
 
        $response = $client->getResponse(); 

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode()); // 400

        $this->assertJsonStringEqualsJsonString(
            json_encode(array("error" => UserUtils::ERROR_PASSWORD)),
            $response->getContent()
        );
    }
    
}
