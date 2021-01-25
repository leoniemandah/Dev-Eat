<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\RestaurantType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crudRestaurant")
 */
class RestaurantController extends AbstractController
{

    /**
     * @Route("/user/{id}/profil", name="restaurant")
     */
    public function index(User $user, OrderRepository $orderRepository): Response
    {
    
        $this->denyAccessUnlessGranted('VIEW', $user);

      
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
        $this->denyAccessUnlessGranted('VIEW', $user);

        $restaurant->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            /**@var UploadedFile  */
            $file = $form->get('LogoFile')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_dir'),
                $filename
            );
            $restaurant->setLogo($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('crud_restaurant_show', ['id' => $restaurant->getId()]));
        }


        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="crud_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        $this->denyAccessUnlessGranted('VIEW', $restaurant);

        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurant $restaurant): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $restaurant);
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**@var UploadedFile  */
            $file = $form->get('LogoFile')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_dir'),
                $filename
            );

            $restaurant->setLogo($filename);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('crud_restaurant_show', ['id' => $restaurant->getId()]));
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/status", name="restaurant_edit", methods={"GET","POST"})
     */

    public function status(Restaurant $restaurant)
     {
     }
}
