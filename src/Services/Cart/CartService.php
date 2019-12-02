<?php
namespace App\Services\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductsRepository;

class CartService {

    protected $session;
    protected $productsRepository;

    public function __construct(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $this->session = $session;
        $this->productsRepository = $productsRepository;
    }

    /**
     * Add product in panier
     * @param integer $id
     * @return void
     */
    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);
        
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else {
            $panier[$id] = 1;
        }
        return $this->session->set('panier', $panier);
    }

    /**
     * Remove products to panier
     * @param integer $id
     * @return void
     */
    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    /**
     * Get full panier
     * @return array
     */
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);
        $panierWhitData = [];

        foreach($panier as $id => $quantity){
            $panierWhitData[] = [
                'product' => $this->productsRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWhitData;
    }

    /**
     * Get Total panier
     * @param array $panierWhitData
     * @return float|null
     */
    public function getTotal(array $cartWhitData): ?float
    {
        $total = 0;
        foreach($cartWhitData as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}