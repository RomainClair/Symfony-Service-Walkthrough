<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\SpecialOfferRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id"="\d+"})
     */
    public function index(Product $product, SpecialOfferRepository $specialOfferRepository): Response
    {
        // Recover the connected user
        $currentUser = $this->getUser();
        // Get the amount of today's discount offer
        $offer = $specialOfferRepository->findSpecialOfferForToday();
        if ($offer === null) {
            $todaysDiscount = 1;
        } else {
            $todaysDiscount = $offer->getDiscount();
        }
        // Get the amount of the personnal loyalty discount for the connected user
        $currentUserDiscount = $currentUser->getLoyaltyDiscount();
        // The user's will have the best of the 2 non cumulative discounts
        if ($todaysDiscount > $currentUserDiscount) {
            $price = $product->getPrice() * $currentUserDiscount;
        } else {
            $price = $product->getPrice() * $todaysDiscount;
        }
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'price' => $price,
        ]);
    }

    // Redefine getUser for test purposes
    protected function getUser()
    {
        $user = new User();
        $user->setLoyaltyDiscount(0.9);
        return $user;
    }
}
