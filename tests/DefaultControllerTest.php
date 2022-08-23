<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{ 

    public function testDefaultPage(): void
    {
        
        $client = static::createClient();

        $client->request('GET', '/');
 
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode()); // 200
    }
}