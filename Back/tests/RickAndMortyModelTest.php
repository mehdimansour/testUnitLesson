<?php
namespace App\Tests;

use App\Model\RickAndMortyModel;

use PHPUnit\Framework\TestCase;

class RickandmortyModelTest extends TestCase
{
    public function testRickAndMortySetName(): void 
    {
        $ramModel = new RickAndMortyModel("fullname","imageuri");
        $ramModel->setName("fullnameModified");
        $this->assertEquals("fullnameModified",$ramModel->getName());
    }

    public function testRickAndMortySetImage(): void 
    {
        $ramModel = new RickAndMortyModel("fullname","imageuri");
        $ramModel->setImage("imageuriModified");
        $this->assertEquals("imageuriModified",$ramModel->getImage());
    }
}