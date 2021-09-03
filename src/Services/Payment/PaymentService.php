<?php
namespace App\Services\Payment;

use App\Entity\User;
use Stripe\StripeClient;
use App\Services\Cart\CartService;

class PaymentService{

    private StripeClient $stipe;

    private CartService $cart;

    public function __construct(StripeClient $stripe, CartService $cart) {
        $this->stipe = $stripe;
        $this->cart = $cart;
    }

    public function makePaymentIntent(?User $user = null): string
    {
        $customer = $this->stipe->customers->create([
            'email' => 'user1@email.com',
            'name' => 'User1'
        ]);

        $payementIntent = $this->stipe->paymentIntents->create([
            'amount' => intval($this->cart->getTotal($this->cart->getFullCart()) *10),
            'currency' => 'eur',
            'customer' => $customer
            // 'email' => 'user1@email.com',
            // 'name' => 'user1'
        ]);
        return $payementIntent->client_secret;
    }
}