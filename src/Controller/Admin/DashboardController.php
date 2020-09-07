<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Size;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(CategoryCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wavestore');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Utilisateurs', 'fa fa-users');
            yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-folder-open', User::class);
            yield MenuItem::linkToCrud('Commentaires', 'fa fa-comments', Comment::class);

        yield MenuItem::section('Produits');
            yield MenuItem::linkToCrud('Produits', 'fa fa-folder-open', Product::class);
            yield MenuItem::linkToCrud('Catégories', 'fa fa-plus', Category::class);
            yield MenuItem::linkToCrud('Tailles', 'fa fa-plus', Size::class);
    }
}
