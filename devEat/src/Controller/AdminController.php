<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Form\UserType;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\MealType;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
* @Route("/admin")
**/
class AdminController extends AbstractController
{
    /**
     * @Route("/{id}/bord", name="admin")
     */
    public function index(User $user, RestaurantRepository $restaurantRepository ): Response
    {
        return $this->render('admin/index.html.twig', [
        'user'=> $user,
        'restaurant' => $restaurantRepository->findCount()
            ]);
    }

    /**
     * @Route("/restaurants/new", name="admin_restaurant_new", methods={"GET","POST"})
     */
    public function newRestaurant(Request $request): Response

    
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_restaurants');
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/restaurants", name="admin_restaurants", methods={"GET"})
     */
    public function restaurants(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }

     /**
     * @Route("/restaurant/{id}", name="admin_restaurant_show", methods={"GET"})
     */
    public function showRestaurant(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

     /**
     * @Route("/restaurant/{id}/edit", name="admin_restaurant_edit", methods={"GET","POST"})
     */
    public function editRestaurant(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**@var UploadedFile  */
            $file =$form->get('LogoFile')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension() ;
            $file->move(
                $this->getParameter('upload_dir'),
                $filename
            );
            
            $restaurant->setLogo($filename);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_restaurants');
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/restaurant/{id}", name="admin_restaurant_delete", methods={"DELETE"})
     */
    public function deleteRestaurant(Request $request, Restaurant $restaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_restaurants');
    }

     /**
     * @Route("/users", name="admin_users", methods={"GET"})
     */
    public function User(UserRepository $userRepository): Response
    {
        $clients = $userRepository->findByRole('[]');
        return $this->render('admin/client.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/user/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $encoder): Response

    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{user}", name="admin_user_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showUser(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{user}/edit", name="admin_user_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editUser(Request $request, User $user ,UserPasswordEncoderInterface $encoder): Response

    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{user}", name="admin_user_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteUser(UserRepository $userRepository , Request $request, User $user, int $id = 0): Response
    {

        
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        
        $user =$userRepository->find($id);

        $User = $this->getUser()->getId();
        if ($User == $id)
        {
          $session = $this->get('session');
          $session = new Session();
          
          $session->invalidate();

        }        
        return $this->redirectToRoute('admin_users');
    }


    /**
     * @Route("/Meal/{id}", name="admin_meal_show", methods={"GET"})
     */
    public function show(Meal $meal): Response
    {
        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
        ]);
    }


    /**
     * @Route("/Meal/{id}/edit", name="admin_meal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meal $meal): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**@var UploadedFile  */
            $file =$form->get('PictureFile')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension() ;
            $file->move(
                $this->getParameter('upload_dir'),
                $filename
            );

            $meal->setPicture($filename);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dev_eat');
        }

        return $this->render('meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Meal/{id}", name="admin_meal_delete", methods={"DELETE"})
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