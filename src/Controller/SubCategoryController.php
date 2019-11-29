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
     * @param Request $request
     * @Route("/category/{slug}-{id}", name="subcategories.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function index(Request $request):Response
    {
      $id = $request->get('id');
      $subCategories = $this->repository->findSubCategory($id);
      return $this->render('categories/subcategory.html.twig',[
        'subcategories' => $subCategories
      ]);
    }    
    
}