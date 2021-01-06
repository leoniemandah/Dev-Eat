<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/restaurant/meal")
 */
class MealController extends AbstractController
{


    
    /**
     * @Route("/{id}/new", name="meal_new", methods={"GET","POST"})
     */
    public function new(int $id = 0, Request $request, RestaurantRepository $restaurantRepository): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);
        $restaurant = $restaurantRepository->find($id);
            
            $meal->setRestaurant($restaurant);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('dev_eat');
        }

        return $this->render('meal/new.html.twig', [
            'meal' => $meal,
            'restaurant' =>$restaurant,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="meal_show", methods={"GET"})
     */
    public function show(Meal $meal): Response
    {
        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="meal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meal $meal): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dev_eat');
        }

        return $this->render('meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meal $meal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dev_eat');
    }
}