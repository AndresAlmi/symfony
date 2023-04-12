<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_product_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();

        $message = null;

        $options = false;

        if($request->query->get('id')){
            $product = $productRepository->find($request->query->get('id'));
        }

        if($request->query->get('selectized')){
            $options = true;
        }

        $form = $this->createForm(ProductType::class, $product, [
            'options' => $options
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $productRepository->save($product, true);

                return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
            }

            $message = "form invalid";
        } 

        return $this->renderForm('product/create.html.twig', [
            'product' => $product,
            'form'    => $form,
            'message' => $message,
        ]);
    }
}
