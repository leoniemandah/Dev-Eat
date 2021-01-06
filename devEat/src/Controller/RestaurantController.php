<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\RestaurantType;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crudRestaurant")
 */
class RestaurantController extends AbstractController
{

    /**
     * @Route("/{id}/Meal", name="AllMeal", methods={"GET"})
     */
    public function Meal(Restaurant $restaurant ,MealRepository $mealRepository){
        
        $meals = $mealRepository->findByRestaurantId();

         return $this->render('meal/index.html.twig', [
        'restaurant' => $restaurant,
        'meals'=> $meals
    ]);
    }

    
    /**
    * @Route("/user/{id}/profil", name="restaurant")
    */
    public function index(User $user): Response
    {

        return $this->render('restaurant/restaurant.html.twig', [
            'user' => $user,

        ]);
    }

    /**
     * @Route("/user/{id}/new", name="restaurant_new", methods={"GET","POST"})
     */
    public function new(int $id = 0, Request $request, UserRepository $userRepository): Response
    {
    
            $restaurant = new Restaurant();
            $form = $this->createForm(RestaurantType::class, $restaurant);
            $form->handleRequest($request);
            $user = $userRepository->find($id);
            
            $restaurant->setUser($user);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($restaurant);
                $entityManager->flush();
    
                return $this->redirectToRoute('restaurant');
            }
        
        

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dev_eat');
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    

}
