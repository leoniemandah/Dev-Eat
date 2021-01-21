<?php

namespace App\Controller;


use App\Entity\Meal;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MealRepository;

class DevEatController extends AbstractController
{
    /**
     * @Route("/", name="dev_eat")
     */

    public function index(string $meals = null, MealRepository $mealRepository, string $category = null, Request $request,  MealRepository $repo): Response
    {

        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);


        if ($searchForm->isSubmitted() && $searchForm->isValid()) {


            $category = $searchForm->getData()['category'];
            $meals = $mealRepository->search($category);

            if ($meals == null) {
                $this->addFlash('erreur', 'Aucune catégorie n\'a été trouvé.');
            }

            return $this->render('meal_views/affiche.html.twig', [
                'meals' => $meals,
            ]);
        }

        return $this->render('dev_eat/index.html.twig', [
            'meals' => $meals,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
