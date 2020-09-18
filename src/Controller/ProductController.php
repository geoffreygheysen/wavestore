<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Comment;
use App\Entity\Product;
use App\Data\SearchData;
use App\Entity\Category;
use App\Form\CommentType;
use App\Form\SearchForm;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        // $sizeRepository = $this->getDoctrine()->getManager()->getRepository(Size::class);
        // $sizes = $sizeRepository->findAll();

        // $categoryRepository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        // $categories = $categoryRepository->findAll();


        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form-> handleRequest($request);
        $products = $productRepository->findSearch($data);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            // 'sizes' => $sizes,
            // 'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET", "POST"})
     */
    public function show(Product $product): Response
    {
        $categoryRepository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        
        $si = [];

        foreach($product->getSize() as $s) {
            $si[$s->getName()][]= $s->getName();
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'sizes' => $si,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
