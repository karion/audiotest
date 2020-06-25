<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

final class CartCreateAction
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function __invoke(): Cart
    {
        if (null === $this->security->getUser()) {
            throw new AccessDeniedException();
        }

        $cart = new Cart();
        $cart->setUser($this->security->getUser());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}
