<?php

namespace App\Tests;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Service\PriceCalculator;

class PriceCalculatorTest extends TestCase
{
    public function testPersonalPrice(): void
    {
        $product = new Product();
        $user = new User();
        $offer = new SpecialOffer();
        $priceCalculator = new PriceCalculator();
        $product->setPrice(10);
        $user->setLoyaltyDiscount(1);
        $offer->setDiscount(1);
        // No discount => price not changed
        $this->assertEquals(10, $priceCalculator->personalPrice($user, $product, $offer));
        $user->setLoyaltyDiscount(0.8);
        // No Special offer => user's loyalty used
        $this->assertEquals(8, $priceCalculator->personalPrice($user, $product, null));
        // Loyalty's best
        $this->assertEquals(8, $priceCalculator->personalPrice($user, $product, $offer));
        // Discount best
        $offer->setDiscount(0.5);
        $this->assertEquals(5, $priceCalculator->personalPrice($user, $product, $offer));

    }
}
