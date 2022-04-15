<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    
    public function testAPIHelloWorld(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(['message' => "Hello world"], $responseData);
    }
    
    public function testAPIFindAll(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/products');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertNotNull($responseData, "response is not null");
    }
    
    public function testAPIAddProducts()
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('POST', '/api/products', ['name' => 'zob', 'price'=> '3500', 'quantity' => 3, 'image' => 'haha']);

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals("zob", $responseData['name']);
        $idToTest = $responseData['id'];
        return $idToTest;
    }
    
    /**
     * @depends testAPIAddProducts
     */
    public function testAPIFindProduct($idToTest): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/products/'.$idToTest);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($idToTest,$responseData['id']);
    }

    /**
     * @depends testAPIAddProducts
     */
    public function testApiAddToCart($idToTest): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('POST', '/api/cart/'.$idToTest, ['quantity' => "1"]);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    
        $this->assertContains(1, $responseData);
    }
    
    public function testApiGetCart(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/cart');
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals(1, $responseData['id']);
    }

    /**
     * @depends testAPIAddProducts
     */
    public function testApiDeleteToCart($idToTest): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('DELETE', '/api/cart/' . $idToTest);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals(1, $responseData['id']);
    }
    
    /**
     * @depends testAPIAddProducts
     */
    public function testApiDeleteProduct($idToTest): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('DELETE', '/api/products/' . $idToTest);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals(['delete' => 'ok'], $responseData);
    }
}
