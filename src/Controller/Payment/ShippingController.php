<?php
namespace App\Controller\Payment;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ShippingController extends AbstractController
{
     /**
     * @Route("/shipping", name="route_shipping")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function shippingChoise(): Response
    {
        $user =  $this->getUser();
        return $this->render('shipping/shipping.html.twig');
    }

}