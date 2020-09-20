<?php

namespace App\Controller;

use App\Entity\Whishlist;
use App\Entity\WhishlistItem;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WhishlistController extends AbstractController
{
    /**
     * @Route("/whishlist", name="whishlist_index")
     */
    public function index()
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $whishlist = $user->getWhishlist();

        return $this->render('whishlist/index.html.twig', [
            'user' => $user,
            'whishlist' => $whishlist,
        ]);
    }

    /**
     * @Route("/whishlist/add/{id}", name="whishlist_add", methods={"GET","POST"})
     */
    public function add($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);

        //recuperer le user
        $user = $this->getUser();

        //recuperer la whishlist
        $whishlist = $user->getWhishlist();

        //Créer une wishlist si le user n'en a pas.
        if (null === $whishlist) {

            $userWhishlist = new Whishlist();
            $user->setWhishlist($userWhishlist);

            $em->persist($user);
            $em->persist($userWhishlist);
            $em->flush();
        }

        //recuperer la whishlist une fois créer
        $whishlist = $user->getWhishlist();

        $item = new WhishlistItem();

        $product = $repository->find($id);

        $item->setProduct($product);
        $item->setWhishlist($whishlist);

        $em->persist($item);

        $whishlist->addItem($item);

        $em->persist($whishlist);
        $em->flush();

        return $this->redirectToRoute('whishlist_index');
    }
}
