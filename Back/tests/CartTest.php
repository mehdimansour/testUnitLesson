<?php
namespace App\Tests;

use App\Entity\Cart;
use App\Entity\Product;

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCreateCart(): void 
    {
        $cart = new Cart();
        echo $cart->getId();
        $this->assertCount(0,$cart->getProducts());
    }

    public function testAddCart(): void 
    {
        $product = new Product();
        $cart = new Cart();
        $cart->addProduct($product);

        $this->assertCount(1,$cart->getProducts());

        $cart->addProduct($product);
        $this->assertCount(1,$cart->getProducts());
    }

    public function testRemoveProductFromCart(): void 
    {
        $product = new Product();
        $cart = new Cart();
        $cart->addProduct($product);
        $this->assertCount(1,$cart->getProducts());

        $cart->removeProduct($product);
        $this->assertCount(0,$cart->getProducts());
    }

}