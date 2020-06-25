<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin
            ->setEmail('admin@karion.net.pl')
            // password1
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$0Q1KeqXf04Lna/Trdn78cw$+Bu2Bjra6CU2oSZ4GfUr4FvMLxWdKuPPa3sBSQUoovc')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ;

        $manager->persist($admin);

        $user = new User();
        $user
            ->setEmail('user@karion.net.pl')
            // password1
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$0Q1KeqXf04Lna/Trdn78cw$+Bu2Bjra6CU2oSZ4GfUr4FvMLxWdKuPPa3sBSQUoovc')
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
