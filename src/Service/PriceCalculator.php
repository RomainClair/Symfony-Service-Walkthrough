<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use App\Entity\User;

class PriceCalculator
{
    public function personalPrice(User $user, Product $product, SpecialOffer $specialOffer): float
    {
        $currentUserDiscount = $user->getLoyaltyDiscount();
        $todaysDiscount = $specialOffer->getDiscount();
        if ($todaysDiscount > $currentUserDiscount) {
            $price = $product->getPrice() * $currentUserDiscount;
        } else {
            $price = $product->getPrice() * $todaysDiscount;
        }
        return $price;
    }
}