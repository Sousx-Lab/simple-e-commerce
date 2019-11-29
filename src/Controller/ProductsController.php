<?php
namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request $request
     * @Route("/products/{slug}-{id}", name="products.index", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function index(Request $request):Response
    {
      $id = $request->get('id');
      $products = $this->repository->findByCategory($id);
      return $this->render('products/index.html.twig',[
        'products' => $products
      ]);
    }
}