<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantsViewsController extends AbstractController
{
    /**
     * @Route("/restaurants/views", name="restaurants_views")
     */
    public function index (RestaurantRepository $repo): Response
    {   
        $restaurants = $repo->findAll();
        return $this->render('restaurants_views/index.html.twig', [
            'restaurants'=> $restaurants
        ]);
    }
}
