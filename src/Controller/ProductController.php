<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\SpecialOfferRepository;
use App\Repository\UserRepository;
use App\Service\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id"="\d+"})
     */
    public function index(
        Product $product,
        SpecialOfferRepository $specialOfferRepository,
        PriceCalculator $priceCalculator
    ): Response {
        $price = $priceCalculator->personalPrice(
            $this->getUser(),
            $product,
            $specialOfferRepository->findSpecialOfferForToday()
        );
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'price' => $price,
        ]);
    }

    // Redefine getUser for test purposes
    protected function getUser()
    {
        $user = new User();
        $user->setLoyaltyDiscount(0.6);
        return $user;
    }
}
