<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use App\Entity\User;
use App\Repository\SpecialOfferRepository;

class PriceCalculator
{

    private SpecialOfferRepository $specialOfferRepository;

    public function __construct(SpecialOfferRepository $specialOfferRepository)
    {
        $this->specialOfferRepository = $specialOfferRepository;
    }

    /**
     * Compute the personnalized price for a product
     * There are two non cumulative discount possible :
     * The discount that can be applied today to every customer
     * The discount of this specific customer according to it's loyalty program
     * Return the price of the product using the best discount
     */
    public function personalPrice(User $user, Product $product): float
    {
        $currentUserDiscount = $user->getLoyaltyDiscount();
        $specialOffer = $this->specialOfferRepository->findSpecialOfferForToday();
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