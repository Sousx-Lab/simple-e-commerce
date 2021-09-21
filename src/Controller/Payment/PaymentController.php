<?php

namespace App\Controller\Payment;

use App\Services\Payment\PaymentService;
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
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function payement(): Response
    {
        $this->isGranted('ROLE_USER');
        $user =  $this->getUser();
        return $this->render('payment/payment.html.twig');
    }

    /**
     * @Route("/checkout", name="route_checkout", methods={"POST"})
     */
    public function checkout(PaymentService $paymentService)
    {
        try {
            $paymentIntents = $paymentService->makePaymentIntent();

            return new JsonResponse(['client_secret' => $paymentIntents->client_secret]);
        } catch (\Throwable $e) {

            throw new ServiceUnavailableHttpException(30, $e->getMessage());
        }
    }
}
