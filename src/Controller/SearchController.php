<?php

namespace App\Controller;

use App\Form\SearchItemType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/item/search", name="search_item")
     */
    public function searchItem(Request $request)
    {
        $searchItemForm = $this->createForm(SearchItemType::class);

        return $this->render('search/item.html.twig', [
            'form' => $searchItemForm->createView(),
        ]);
    }
}
