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
    public function index(Products $products, int $id): Response
    {
      $products = $this->repository->findBySubCategory($id);
      if($products === null ){
        throw new NotFoundHttpException('Aucun article dans cette catégorie');
      }
      return $this->render('products/index.html.twig',[
        'products' => $products
      ]);
    }
}