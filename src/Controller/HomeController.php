<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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

    
    // SELECT: findAll (chercher par un ou plusieurs champs, filtre array)
    #[Route("home/liste")]
    public function exempleFindAll(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        $rep = $em->getRepository(Produit::class);

        // notez que findBy renverra toujours un array même s'il trouve qu'un objet
        $produits = $rep->findAll();

        $vars = ['produits' => $produits];

        return $this->render("home/liste.html.twig", $vars);
    }


}
