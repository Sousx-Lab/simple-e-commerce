<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $repository
     * @return Response
     */
    public function index(CategoryRepository $repository):Response
    {
      $categories = $repository->findAll(); 
      return $this->render('home/home.html.twig',[
        'categories' => $categories
      ]);  
    }
}