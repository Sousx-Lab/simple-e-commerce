<?php
namespace App\Controller;

use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubCategoryController extends AbstractController
{
    /**
     * @var $SubCategoryRepository
     */
    private $repository;

    public function __construct(SubCategoryRepository $repository)
    {
        $this->repository = $repository ;
    }

    /**
     * @param int $id
     * @Route("/category/{slug}-{id}", name="subcategories.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function index(int $id):Response
    {
      $subCategories = $this->repository->findSubCategory($id);
      return $this->render('categories/subcategory.html.twig',[
        'subcategories' => $subCategories
      ]);
    }    
    
}