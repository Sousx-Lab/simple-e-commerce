<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Categories\Category;
use App\Entity\Products\Products;
use App\Entity\Products\ProductVariations;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="route_admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ProductsCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->getParameter('shop_name'));
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy');

    }

    public function configureMenuItems(): iterable
    {
        $products = [
            MenuItem::linkToCrud('Products', 'fas fa-cubes', Products::class),
            MenuItem::linkToCrud('Product Variations', 'fas fa-barcode', ProductVariations::class),
            
        ];
        yield MenuItem::subMenu('Products', 'fas fa-cube')->setSubItems($products);
        yield MenuItem::linkToCrud('Category', 'fas fa-tag', Category::class);
        yield MenuItem::linkToCrud('Customers', 'fas fa-users', User::class);
        
    }
}
