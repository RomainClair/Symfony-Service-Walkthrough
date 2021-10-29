<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\SpecialOfferRepository;
use App\Repository\UserRepository;
use App\Service\PriceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id"="\d+"})
     */
    public function index(Product $product, PriceCalculator $priceCalculator): Response 
    {
        $price = $priceCalculator->personalPrice($this->getUser(), $product);
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'price' => $price,
        ]);
    }

    /**
     * @Route("/add", name="add-product)
     */
    public function add(EntityManagerInterface $manager): Response
    {
        // Creating a new product
        $product = new Product();
        // Initialiazing the product, for example using a form
        // ...
        // Save the product
        $manager->persist($product);
        $manager->flush();
        // Generate a response, for example a redirection
    }

    // Redefine getUser for test purposes
    protected function getUser()
    {
        $user = new User();
        $user->setLoyaltyDiscount(0.6);
        return $user;
    }
}
