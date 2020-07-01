<?php


namespace Tests\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\Traits\Endpoints\ApiCartTrait;
use Tests\Traits\Endpoints\ApiLoginTrait;
use Tests\Traits\Endpoints\ApiProductTrait;
use Tests\Traits\ResponseHandlerTrait;

class CartApiTest extends WebTestCase
{
    use ResponseHandlerTrait;
    use ApiLoginTrait;
    use ApiProductTrait;
    use ApiCartTrait;

    public function setUp(): void
    {
        self::bootKernel();
        self::setupClient();
    }

    public function testCart()
    {
        $userToken = $this->getUserToken();

        $products = $this->productList([], $userToken);

        $cart = $this->cartCreate([], $userToken);
        $this->assertCount(0, $cart['products']);

        $cart = $this->cartAddProduct($cart['id'], $products[0]['id'], $userToken);
        $this->assertCount(1, $cart['products']);

        $cart = $this->cartAddProduct($cart['id'], $products[0]['id'], $userToken);
        $this->assertCount(1, $cart['products']);

        $cart = $this->cartAddProduct($cart['id'], $products[1]['id'], $userToken);
        $this->assertCount(2, $cart['products']);

        $cart = $this->cartAddProduct($cart['id'], $products[2]['id'], $userToken);
        $this->assertCount(3, $cart['products']);

        $products2page = $this->productList(['page' => 2], $userToken);

        $cart = $this->cartAddProduct($cart['id'], $products2page[0]['id'], $userToken, Response::HTTP_BAD_REQUEST);
    }

}