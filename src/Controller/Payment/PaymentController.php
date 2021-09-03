<?php

namespace App\Controller\Payment;

use App\Services\Payment\PaymentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PaymentController extends AbstractController
{

    /**
     * @Route("/payment", name="route_payment")
     * @return Response
     */
    public function payement(): Response
    {
        return $this->render('payement/payement.html.twig');
    }

    /**
     * @Route("/checkout", name="route_checkout", methods={"POST"})
     */
    public function checkout(Request $request, PaymentService $paymentService)
    {
        $paymentIntents = $paymentService->makePaymentIntent();
        if (!$paymentIntents) {
            throw new ServiceUnavailableHttpException(30, 'ERROR');
        }

        return new JsonResponse(['client_secret' => $paymentIntents]);
    }
}