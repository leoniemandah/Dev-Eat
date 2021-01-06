<?php

namespace App\Controller;

use App\Entity\Restaurant;
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


     /**
     * @Route("/restaurants/{id}", name="restaurant_show")
     */
    public function show(Restaurant $restaurant)
    {

        return $this->render('restaurants_views/show.html.twig', ['restaurant' => $restaurant]);
    }
}
