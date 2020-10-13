<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Product;
use App\Data\SearchData;
use App\Entity\Category;
use App\Form\SearchType;
use App\Form\CommentType;
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
     * @Route("/", name="product_index", methods={"GET", "POST"})
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        //$data = new SearchData();
        //$form = $this->createForm(SearchType::class, $data);

        // $form->handleRequest($request);
        //$products = $productRepository->findCategory($data);
        //$products = $productRepository->findSize($data);

        $post_categories = isset($_POST['categories']) ? $_POST['categories'] : null;
        $post_sizes = isset($_POST['sizes']) ? $_POST['sizes'] : null;

        $productRepository = $this->getDoctrine()->getManager()->getRepository(Product::class);

        if (null === $post_categories && null === $post_sizes) {
            $products = $productRepository->findAll();
        } else {
            $products = $productRepository->findByCategoriesAndSizes($post_categories, $post_sizes);
        }

        $categoryRepository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $form['categories'] = $categoryRepository->findAll();

        $sizeRepository = $this->getDoctrine()->getManager()->getRepository(Size::class);
        $form['sizes'] = $sizeRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form,
            'post' => [
                'categories' => $post_categories,
                'sizes' => $post_sizes
            ]
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
    public function show($id, Product $product): Response
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
