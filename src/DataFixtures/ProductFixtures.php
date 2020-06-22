<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Money;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $productGF = (new Product())
            ->setName('The Godfather')
            ->setPrice((new Money)->setCents(5999)->setCurrency('PLN'))
        ;

        $productSJ = (new Product())
            ->setName('Steve Jobs')
            ->setPrice((new Money)->setCents(4995)->setCurrency('PLN'))
        ;
        $productTRSH = (new Product())
            ->setName('The Return of Sherlock Holmes')
            ->setPrice((new Money)->setCents(3999)->setCurrency('PLN'))
        ;
        $productLP = (new Product())
            ->setName('The Little Prince')
            ->setPrice((new Money)->setCents(2999)->setCurrency('PLN'))
        ;
        $productIHM = (new Product())
            ->setName('I Hate Myselfie!')
            ->setPrice((new Money)->setCents(1999)->setCurrency('PLN'))
        ;
        $productT = (new Product())
            ->setName('The Trial')
            ->setPrice((new Money)->setCents(999)->setCurrency('PLN'))
        ;

        $manager->persist($productGF);
        $manager->persist($productSJ);
        $manager->persist($productTRSH);
        $manager->persist($productLP);
        $manager->persist($productIHM);
        $manager->persist($productT);

        $manager->flush();
    }
}
