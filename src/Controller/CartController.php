<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private CartService $cartService;

    use TargetPathTrait;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/panier", name="cart.index")
     * @return Response
     */
    public function index(): Response
    {
        $panierWhitData = $this->cartService->getFullCart();

        return $this->render('cart/index.html.twig', [
            'items' => $panierWhitData,
            'total' => $this->cartService->getTotal($panierWhitData),
        ]);
    }

    /**
     * @Route("/panier/add", name="cart.add", methods={"POST"}) 
     * @return Response
     */
    public function add(Request $request): Response
    {
        if ($this->isCsrfTokenValid("add_cart_token", $request->request->get("add_cart"))) {
            $id = $request->request->get('product_id');

            $this->cartService->add($id);

            $this->addFlash('notice', 'Votre produit a été ajouté au panier');

            if ($targetPath = $request->request->get('referer')) {
                return new RedirectResponse($targetPath);
            }
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/panier/remove", name="cart.remove", methods={"POST"})
     * @return Response
     */
    public function remove(Request $request): Response
    {
        if ($this->isCsrfTokenValid("remove_cart_token", $request->request->get("remove_cart"))) {
            $id = $request->request->get('product_id');

            if (null !== $id) {
                $this->cartService->remove($id);
            }

            $this->addFlash('notice', 'L\'article à bien été supprimer du panier');

            return $this->redirectToRoute("cart.index");
        }

        return $this->redirectToRoute("cart.index");
    }
}
