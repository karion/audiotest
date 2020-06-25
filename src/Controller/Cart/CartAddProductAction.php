<?php

namespace App\Controller\Cart;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CartAddProductAction
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;

        $this->validator = $validator;
    }

    public function __invoke(Cart $data, string $productId): Cart
    {
        /** @var Product|null $product */
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if (null === $product) {
            throw new NotFoundHttpException();
        }

        $data->addProduct($product);

        $violations = $this->validator->validate($data);

        if ($violations && $violations->count()) {
            throw new ValidationException($violations);
        }

        $this->entityManager->flush();

        return $data;
    }
}
