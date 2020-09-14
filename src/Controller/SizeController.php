<?php

namespace App\Controller;

use App\Repository\SizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SizeController extends AbstractController
{
    /**
     * @Route("/size", name="size")
     */
    public function index(SizeRepository $sizeRepository)
    {
        return $this->render('size/index.html.twig', [
            'sizes' => $sizeRepository->findAll(),
        ]);
    }
}
