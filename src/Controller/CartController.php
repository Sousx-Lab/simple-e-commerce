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

    private $cartService;

    public function __construct(SessionInterface $session, CartService $cartService)
    {
        $this->session = $session;
        $this->cartService = $cartService;
        
    }

    /**
     * @Route("/panier", name="cart.index")
     */
    public function index()
    {
        $panierWhitData = $this->cartService->getFullCart();
        return $this->render('cart/index.html.twig', [
            'items' => $panierWhitData,
            'total' => $this->cartService->getTotal($panierWhitData),
        ]);
    }

    /**
     * @Route("/panier/add", name="cart.add") 
     * @return void
     */
    public function add(Request $request)
    {
        $id = $request->request->get('panier');
        $this->cartService->add($id);

        $this->addFlash('notice', 'Votre produit a été ajouté au panier');
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/panier/remove/{id}", name="cart.remove")
     * @return void
     */
    public function remove(int $id)
    {
        $this->cartService->remove($id);
        $this->addFlash('notice', 'L\'article à bien été supprimer du panier');
        return $this->redirectToRoute("cart.index");
    }

}
