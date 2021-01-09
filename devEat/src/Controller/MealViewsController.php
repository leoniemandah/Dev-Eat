<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealViewsController extends AbstractController
{
    /**
     * @Route("/meal/views/{id}", name="meal_views")
     */
    public function index(Meal $meal): Response
    {
        return $this->render('meal_views/index.html.twig', [
            'controller_name' => 'MealViewsController',
            'meal' => $meal,
        ]);
    }

     /**
     * @Route("/meal/views", name="meal_b")
     */
    public function burger(MealRepository $mealRepository): Response
    {
        $meal = $mealRepository->findByCategory();
        return $this->render('meal_views/burger.html.twig', [
            'controller_name' => 'MealViewsController',
            'meal' => $meal,
        ]);
    }

}


     