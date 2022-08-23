<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


use Symfony\Component\HttpFoundation\Response;

use Faker\Factory;
use Faker\Generator;

class ApiControllerTest extends WebTestCase
{ 

    public function testCitiesNotFound(): void
    {

        $client = static::createClient();

        $client->request('GET', '/api/cities/');
 
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode()); // 404
    }

    public function testCitiesJsonResponse(): void 
    {

        $q = 'le pecq';
        $client = static::createClient();

        $client->request('GET', '/api/cities/' . $q);
 
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode()); // 200S
        $this->assertEquals($q, $content['query']);
    }
}