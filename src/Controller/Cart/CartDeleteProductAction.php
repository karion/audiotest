<?php

namespace App\Controller\Cart;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

final class CartDeleteProductAction
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Cart $data, string $productId): Cart
    {
        /** @var Product|null $product */
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if (null === $product) {
            throw new NotFoundHttpException();
        }

        $data->removeProduct($product);

        $this->entityManager->flush();

        return $data;
    }
}
