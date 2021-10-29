<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Generating some products
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setPrice(rand(0, 1000) / 100);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
