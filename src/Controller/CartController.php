<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Cart;
use App\Entity\Product;
use App\Helper\CartHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/cart/add", name="cart_add")
     */
    public function add()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);

        $user = $this->getUser();
        $cart = $user->getCart();

        //Si le user n'a pas de panier, il en crée vite un
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
        
        $product = $repository->findOneBy(['id' => $_POST['product_id']]);

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

    
}
