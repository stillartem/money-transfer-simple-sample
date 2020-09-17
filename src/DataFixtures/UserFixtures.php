<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $fixturesUsers = [
            'name' => 'Artem',
        ];
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}