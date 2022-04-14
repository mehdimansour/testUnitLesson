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
        //$this->assertEquals($HERE, $responseData);
    }
    
    public function testAPIAddProducts(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('POST', '/api/products', ['name' => 'zob', 'price'=> '3500', 'quantity' => 3, 'image' => 'haha']);
        

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(["id" => 21,"name" => "zob", "price"=> "3500", "quantity" => 3, "image" => "haha"], $responseData);
    }
    
    public function testAPIFindProduct(): void
    {
        $client = static::createClient();
        // Request a specific page
        $IDProduct = "15";
        $client->jsonRequest('GET', '/api/products/'.$IDProduct);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($IDProduct,$responseData['id']);
    }
    
    public function testApiDeleteProduct(): void
    {
        $client = static::createClient();
        // Request a specific page
        $IDProduct = "15";
        $client->jsonRequest('DELETE', '/api/products/' . $IDProduct);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals(['delete' => 'ok'], $responseData);
    }
    
    public function testApiAddToCart(): void
    {
        $client = static::createClient();
        // Request a specific page
        $IDProduct = "61";
        $client->jsonRequest('POST', '/api/cart/'.$IDProduct, ['quantity' => 1]);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    
        $this->assertEquals(['id' => 1, 'products' => ['id' => 61, 'name'=> 'Rick Sanchez', 'price' => 8, 'quantity' => 20, 'image' => 'https:\/\/rickandmorty.com\/api\/character\/avatar\/1.jpg']], $responseData);
    }
    
    public function testApiGetCart(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->jsonRequest('GET', '/api/cart/');
        $response = $client->getResponse();
        $this->assertResponseIsUnprocessable();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals('products' => {['id' => 61, 'name'=> 'Rick Sanchez', 'price' => 8, 'quantity' => 20, 'image' => 'https:\/\/rickandmorty.com\/api\/character\/avatar\/1.jpg']}, $responseData);
    }

    public function testApiDeleteToCart(): void
    {
        $client = static::createClient();
        // Request a specific page
        $IDProduct = "15";
        $client->jsonRequest('DELETE', '/api/cart/' . $IDProduct);
        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        //ToCheck
        $this->assertEquals(['id' => 1, 'products' => {}], $responseData);
    }
}
