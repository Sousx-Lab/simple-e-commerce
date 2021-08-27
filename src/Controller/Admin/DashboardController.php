<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Products;
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
        $submenu1 = [
            MenuItem::linkToCrud('Products List', 'fas fa-cube', Products::class),
        ];

        $submenu2 = [
            MenuItem::linkToCrud('Category', 'fas fa-tag', Category::class),
        ];

        $submenu3 = [
            MenuItem::linkToCrud('Users List', 'fas fa-user', User::class),
        ];

        yield MenuItem::subMenu('Products', 'fas fa-cubes')->setSubItems($submenu1);
        yield MenuItem::subMenu('Categories', 'fas fa-tags')->setSubItems($submenu2);
        yield MenuItem::subMenu('Users', 'fas fa-id-card')->setSubItems($submenu3);
    }
}
