<?php


namespace Tests\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Traits\Endpoints\ApiLoginTrait;
use Tests\Traits\Endpoints\ApiProductTrait;
use Tests\Traits\ResponseHandlerTrait;

class ProductApiTest extends WebTestCase
{
    use ResponseHandlerTrait;
    use ApiLoginTrait;
    use ApiProductTrait;

    public function setUp(): void
    {
        self::bootKernel();
        self::setupClient();
    }

    public function testList()
    {
        $userToken = $this->getUserToken();

        $products = $this->productList([], $userToken);

        $this->assertCount(3, $products);

        $productsSecondPage = $this->productList(['page' => 2], $userToken);

        $this->assertCount(3, $products);

        $this->assertNotEquals($products, $productsSecondPage);
    }



}