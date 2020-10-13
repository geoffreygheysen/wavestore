<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $cart = $user->getCart();

        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add", methods={"GET","POST"})
     */
    public function add($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);

        $user = $this->getUser();
        $cart = $user->getCart();

        //Si le user n'a pas de panier, il en crée un
        if (null === $cart){
            $userCart = new Cart();
            $user->setCart($userCart);
            $entityManager->persist($user);
            $entityManager->persist($userCart);
            $entityManager->flush();
        }

        $cart = $user->getCart();

        //TODO Vérifier les infos du post

        $item = new CartItem();
        
        $product = $repository->find($id);

        //TODO Vérifier produit existe

        $item->setQuantity($_POST['product_quantity']);
        $item->setProduct($product);
        $item->setCart($cart);

        $entityManager->persist($item);

        $cart->addItem($item);

        $entityManager->persist($cart);
        $entityManager->flush();

        return $this->redirectToRoute('cart_index');

    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove", methods={"GET","POST"})
     */
    public function remove($id)
    {
         $user = $this->getUser();
         $cart = $user->getCart();
         $items = $cart->getItems();

         $entityManager = $this->getDoctrine()->getManager();
         $repository = $this->getDoctrine()->getManager()->getRepository(CartItem::class);
         $itemToRemove = $repository->findOneById($id);

         //dd($items);

         if (null === $itemToRemove) {
             //TODO Error not found
            return $this->redirectToRoute('cart_index');
         }

         $cart->removeItem($itemToRemove);

        $entityManager->persist($cart);
        $entityManager->flush();

        return $this->redirectToRoute('cart_index');

         //dd($cart);
    }
}
