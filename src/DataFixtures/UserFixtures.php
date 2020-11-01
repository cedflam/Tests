<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 1; $i++) {
            $user = new User();
            $user->setEmail('ced@gmail.com')
                ->setPassword('test');
            $manager->persist($user);
        }
        $manager->flush();
    }
}