<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
  * Class ItemControllerTest
  * @package App\Tests\Controller
  * @author Tom Dubiel <oconnor7777@gmail.com>
  */
class ItemControllerTest extends WebTestCase
{

    /**
     * @test
     */
    public function fetchItemsIsSuccessful()
    {
        $client = self::createClient();
        $client->request('GET', '/api/items');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function responseContentTypeIsApplicationJson()
    {
        $client = self::createClient();
        $client->request('GET', '/api/items');

        $responseHeaders = $client->getResponse()->headers;

        $this->assertTrue($responseHeaders->has('content-type'));
        $this->assertSame('application/json', $responseHeaders->get('content-type'));
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @test
     */
    public function postItemIsSuccessful()
    {
        $client = self::createClient();
        $client->request('POST', '/api/items', ['name' => 'new item', 'price' => '9.99']);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
	 * @test
	 */
    public function postItemPropertyIsSuccessful()
    {
        $client = self::createClient();
        $client->request('POST', '/api/items/1', ['name' => 'new property']);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
	 * @test
	 */
    public function putItemIsSuccessful()
    {
        $client = self::createClient();
        $client->request('PUT', '/api/items/1', ['name' => 'new item name', 'price' => '19.99']);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
	 * @test
	 */
    public function deleteItemIsSuccessful()
    {
        $client = self::createClient();
        $client->request('DELETE', '/api/items/1');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}