<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfilController extends AbstractController {

    /**
     * @Route("/profile/", name="user.profile")
     * @return Response
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($this->getUser()){
            return $this->render('profile/index.html.twig');
        };        
    }

}