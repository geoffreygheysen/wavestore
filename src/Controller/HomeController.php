<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $productRepository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $products = $productRepository->findBy(array(), array('id' => 'desc'),4,0);

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
