<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    //se entro nel sito -> vedo indexView : lista prodotti
    //se mi loggo 'correttamente' ->ritorno in indexView : lista prodotti
    #[Route('/home', name: 'homePage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    //loggarmi é gestito da SecurityController (-> vieWLogin), 
    //mi loggo con successo -> gestito da Authentocator mi redirige a HomeController, Index()

    //se faccio logout, sono rediretto a IndexView
    #[Route('/home/logout', name: 'seLogout')]
    public function seLogout(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
