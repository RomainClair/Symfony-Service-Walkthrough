<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\SpecialOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(Product $product, SpecialOfferRepository $specialOfferRepository): Response
    {
        // Recover the connected user
        $currentUser = $this->getUser();
        $todaysDiscount = $specialOfferRepository->findSpecialOfferForToday()->getDiscount();
        $currentUserDiscount = $this->getUser()->getLoyaltyDiscount();
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
}
