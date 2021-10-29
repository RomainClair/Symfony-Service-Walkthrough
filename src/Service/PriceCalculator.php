<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use App\Entity\User;

class PriceCalculator
{
    /**
     * Compute the personnalized price for a product
     * There are two non cumulative discount possible :
     * The discount that can be applied today to every customer
     * The discount of this specific customer according to it's loyalty program
     * Return the price of the product using the best discount
     */
    public function personalPrice(User $user, Product $product, ?SpecialOffer $specialOffer): float
    {
        $currentUserDiscount = $user->getLoyaltyDiscount();
        if ($specialOffer !== null) {
            $todaysDiscount = $specialOffer->getDiscount();
        } else {
            $todaysDiscount = 1;
        }
        if ($todaysDiscount > $currentUserDiscount) {
            $price = $product->getPrice() * $currentUserDiscount;
        } else {
            $price = $product->getPrice() * $todaysDiscount;
        }
        return $price;
    }
}