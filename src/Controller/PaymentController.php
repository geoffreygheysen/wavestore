<?php

namespace App\Controller;

use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentController extends AbstractController
{
    const YOUR_DOMAIN = 'http://localhost:8000';

    /**
     * @Route("/create-checkout-session", name="create-checkout-session")
     */
    public function createCheckoutSession(Request $request): JsonResponse
    {
        \Stripe\Stripe::setApiKey('sk_test_51HTo0jLagNSJl2L8TVg9hONFOobYCvezTgftYFRVHbVPYsCDod5CyRZmsFTWlMOBGMbuJYjyrFck94vOngQaYR8M00lp9u5W4Z');

        $data = [
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'unit_amount' => 5000,
                'product_data' => [
                  'name' => 'Votre Panier',
                  'images' => ["https://i.imgur.com/EHyR2nP.png"],
                ],
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => self::YOUR_DOMAIN . '/checkout/success',
            'cancel_url' => self::YOUR_DOMAIN . '/checkout/cancel',
            ];

        $checkout_session = \Stripe\Checkout\Session::create($data);
          //echo json_encode(['id' => $checkout_session->id]);

          return new JsonResponse(['id' => $checkout_session->id]);
    }
}
