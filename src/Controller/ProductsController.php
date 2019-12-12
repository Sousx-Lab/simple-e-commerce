<?php
namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @var $ProductsRepository
     */
    private $repository;

    public function __construct(ProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @Route("/products/{slug}-{id}", name="products.index", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function index(int $id): Response
    {
      $products = $this->repository->findBySubCategory($id);
      if(!$products){
        throw $this->createNotFoundException("Aucun article dans cette catégorie");
      }
      return $this->render('products/index.html.twig',[
        'products' => $products
      ]);
    }

    /**
     * @param Products $products
     * @Route("/product/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Products $product, string $slug)
    {
      if($product->getSlug() !== $slug){
        return $this->redirectToRoute('product.show', [
          'id'   => $product->getId(),
          'slug' => $product->getSlug()
        ], 301);
      }
      return $this->render('products/show.html.twig', [
        'product' => $product,
      ]);

    }
}