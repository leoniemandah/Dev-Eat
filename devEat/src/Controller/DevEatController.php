<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevEatController extends AbstractController
{
    /**
     * @Route("/", name="dev_eat")
     */
    
    public function index(): Response
    {
        return $this->render('dev_eat/index.html.twig', [
        ]);
    }
}
