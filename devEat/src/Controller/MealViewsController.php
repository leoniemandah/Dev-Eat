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
     * @Route("/meal/views/category/{category}", name="meal")
     */
    public function categoryMeal(MealRepository $mealRepository, string $category): Response
    {
        $meal = $mealRepository->findByCategory($category);
        return $this->render('meal_views/affiche.html.twig', [
            'meals' => $meal,
        ]);
    }
}
