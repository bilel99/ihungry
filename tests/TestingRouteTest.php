<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestingRouteTest extends WebTestCase
{
    /**
     * Testing Routing name
     */
    public function testPageIsSuccessfull()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}
