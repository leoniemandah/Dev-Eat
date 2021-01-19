<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderMeal;
use App\Entity\User;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Code\Generator\DocBlock\Tag\ReturnTag;
use Mailgun\Mailgun;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
/**
* @Route("/user")
**/
class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, MealRepository $mealRepository, UserInterface $user): Response
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

        $total +=2.50;


        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
            ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add(int $id, SessionInterface $session, MealRepository $mealRepository)
    {
        $panier = $session->get('panier', []);

        if(empty($panier)){  
            $panier[$id] = 1 ;      
        }
        else if(!empty($panier[$id])){  
        $restoPanier = $mealRepository->find($id)->getRestaurant()->getId();

        $RestoOrder = $mealRepository->find(array_key_first($panier))->getRestaurant()->getId();
            if($restoPanier === $RestoOrder ){
                $panier[$id]++;

            }
            else{
                $this->addFlash( 'danger',
                'Vous pouvez commander uniquement dans un restaurant'
              );
                return $this->redirectToRoute('restaurants_views');
            }
        }
        else{
            $restoPanier = $mealRepository->find($id)->getRestaurant()->getId();

            $RestoOrder = $mealRepository->find(array_key_first($panier))->getRestaurant()->getId();

            if($restoPanier === $RestoOrder ){
                $panier[$id] = 1 ;         
            }
            else{
                $this->addFlash( 'danger',
                'Vous pouvez commander uniquement dans un restaurant'
              );
                return $this->redirectToRoute('restaurants_views');
            }
        }

        $session->set('panier', $panier);

        $this->addFlash(
            'success',
            'Votre plat a bien été enregistrée !'
        );    
        $restoPanier = $mealRepository->find($id)->getRestaurant()->getId();

        return $this->redirect($this->generateUrl('restaurant_show', [ 'id' => $restoPanier]));


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
     public function order(SessionInterface $session, MealRepository $mealRepository,User $user, MailerInterface $mailer)
     {
         $order = new Order;
         
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

        $totalResto = $total;
        $total +=2.50;

        if($user->getSolde() >= $total ){

            $order->setUser($user);

            $order->setStatus(1);
    
            $order->setOrderHour(new \DateTime('now'),'+1 hour');
    
            $order->setDeliveryHour(date_modify(new \DateTime('now'),'+2 hour'));
            
            $panierWithData = [];

            
            foreach($panier as $id => $quantity){
                $panierWithData[] = [
                    'meal' => $Meals = $mealRepository->find($id),
                    'quantity' => $quantity
                ];
                $orderMeal = new OrderMeal;
                $orderMeal->setMeal($Meals);
                $orderMeal->setOrderId($order);
                $orderMeal->setQuantity($quantity);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($orderMeal);
            }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($order);
                $entityManager->flush();


                $email = (new TemplatedEmail())
                ->from('johanna.dezarnaud@orange.fr')
                ->to('johanna.dezarnaud@orange.fr')
                ->subject('Commande n°'.$order->getId())
                ->htmlTemplate('mail/commande.html.twig')
                ->context([
                    'order' => $order,
                    'orderMeal' => $orderMeal,
                    'totalResto' => $totalResto,
                    'user' => $user,   
                    'items' => $panierWithData,
                    ]);
    
            $mailer->send($email);

            $session->clear();
         
            $this->addFlash(
                            'success',
                            'Votre commande a bien été enregistrée !'
                        );

            return $this->redirectToRoute("panier");
           
        }
        else{
            $this->addFlash( 'danger',
            'Une erreur est survenue pendant l\'enregistrement de votre commande verifier votre solde'
          );
        }

        return $this->redirectToRoute("panier");


    }
}
