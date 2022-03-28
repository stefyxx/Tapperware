<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\PrototypeProduit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

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

    
    #[Route("/home/liste", name:'lista')]
    public function listeFindAll(ManagerRegistry $doctrine) :Response
    {
        $em = $doctrine->getManager();
        $repo = $em->getRepository(PrototypeProduit::class);
        //services
        $repoCat = $em->getRepository(Category::class);
        
        $produits = $repo->findAll();
        $allCategory=$repoCat->findAll();
        
        // notez que findBy renverra toujours un array même s'il trouve qu'un objet

        $vars = ['produits' => $produits,
                    'categories'=> $allCategory];

        return $this->render("home/liste.html.twig", $vars);
    }

    #[Route("home/deatil/{id}", name:"home/deatil/{id}")]
    public function detailsProduit(ManagerRegistry $m){
        $em= $m->getManager();
        $repo= $em->getRepository(PrototypeProduit::class);

        $prototipe = $repo->find(1);
        return $this->render("home/details.html.twig",[
            'prodotto'=>$prototipe
        ]);
    }


}
