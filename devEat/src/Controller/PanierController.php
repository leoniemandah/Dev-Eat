<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/user")
**/
class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, MealRepository $mealRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'meal' => $mealRepository->find($id),
                'quantity' => $quantity,
            ];
        }

        $total = 0;

        foreach($panierWithData as $item){
            $totalItem = $item['meal']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }


        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
            ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

    
        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id] = 1 ;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');

    }

    /**
     * @Route("/panier/remove/{id}" , name="panier_delete")
     */
     public function delete (SessionInterface $session, $id){
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");
     }


     /**
     * @Route("/{id}/order" , name="panier_order")
     */
     public function order(SessionInterface $session, MealRepository $mealRepository,User $user)
     {
         $order = new Order;
         
         $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'meal' => $mealRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $order->setUser($user);

        $order->setStatus(1);

        $order->setOrderHour(new \DateTime('now'));

        $order->setDeliveryHour(date_modify(new \DateTime('now'),'+1 hour'));

        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('dev_eat');



    
    }
}
