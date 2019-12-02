<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        
    }

    /**
     * @Route("/panier", name="cart.index")
     */
    public function index(CartService $cartService)
    {
        $panierWhitData = $cartService->getFullCart();

        return $this->render('cart/index.html.twig', [
            'items' => $panierWhitData,
            'total' => $cartService->getTotal($panierWhitData)
        ]);
    }

    /**
     * @Route("/panier/add", name="cart.add") 
     * @return void
     */
    public function add(Request $request, CartService $cartService)
    {
        $id = $request->request->get('panier');
        $cartService->add($id);

        $this->addFlash('notice', 'Votre produit a été ajouté au panier');
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/panier/remove/{id}", name="cart.remove")
     * @return void
     */
    public function remove(int $id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute("cart.index");
    }
}
