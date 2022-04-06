<?php

namespace App\Controller;

use App\Entity\DetailProduitLocation;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use App\Repository\PrototypeProduitRepository;
use App\Repository\RestaurantRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

#[Route('/panier')]
class PanierController extends AbstractController
{
    /*#[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }*/

    //il paniere é registrato con 3 actions, NON CREO UN DetailProduitLocation!
    #[Route('/', name: 'app_panier_index',methods: ['GET', 'POST'])]
    public function index(SessionInterface $session, PrototypeProduitRepository $productRepository, RestaurantRepository $RestaurantServices): Response
    {
        //lista dei Resto di chi é loggato
        $listaResto = $RestaurantServices->findBy(['User'=> $this->getUser()]);

        //guarda nella $session se hai un dati che si chiama 'panier', se no, sarà un array vuoto
        $panier =$session->get('panier', []);

        //rifaccio un paniere che ha più di un id e le quantità
        //$panier è un array associativo: 'id_prodotto'=>'quantita_prodotto'

        //ossia $panier =[$id => $quantity,
        //                $id => $quantity, ...] //devo aggiungere id_resto

        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[]=[
                'product'=>$productRepository->find($id),        //new product()->getReposiroty()->find(id);
                'quantity' =>$quantity 
            ];
        }

        $total=0;
        foreach ($panierWithData as $item) {
            //totale di 1 prodotto
            $totalItem= $item['product']->getPrixLocationUnitaire() * $item['quantity'];
            //totale di tutto
            $total += $totalItem;
        }

        //se ho selezionato il ristorante
        $id_resto = $session->get('id_resto');
        if ($id_resto) {
            $resto= $RestaurantServices->find($id_resto);
            return $this->render('panier/index.html.twig', [
                'controller_name' => 'PanierController',
                'items' => $panierWithData,
                'panier'=> $panier,
                'totale' => $total,
                'Restos'=> $listaResto,
                'resto' => $resto
            ]);
        }else {
            return $this->render('panier/index.html.twig', 
            [
                'controller_name' => 'PanierController',
                'items' => $panierWithData,
                'panier'=> $panier,
                'totale' => $total,
                'Restos'=> $listaResto,
            ]);   
        }

    }

    #[Route(path:'/add/{id}', name:'produit_add')]
    public function add($id, SessionInterface $session, RestaurantRepository $RestaurantServices){
        //$session = $request->getsession();    // non é mpiu' necessario perché ho SessionInterface $session 

        //guarda nella session e cerca 'panier', se non trovi niente (ancora non ho scelto niente), dammi un tab vuoto
        $panier =$session->get('panier', []);
        //$id_resto = $session->get('id_resto');
        //$resto= $RestaurantServices->find($id_resto);

        if (!empty($panier[$id])) {
            //se riclicco sullo stesso prodotto, aumento la quantità
            $panier[$id]+=10;
        } else {
            //se clicco 1 volta sul prodotto, aggiungo quantità 1
            $panier[$id]=10;
        }
        $session->set('panier', $panier);
        //$session->set('resto', $resto);
        return $this->redirectToRoute('app_panier_index');
    }

    #[Route(path:'/remove/{id}', name:'produit_remove')]
    public function remove($id, SessionInterface $session){
        //voglio sopprimere 10 quantità di un articolo dal paniere
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]-=10;
            //se arrivo a 0 tolglo l'aricolo
            if($panier[$id]<=10){
                unset($panier[$id]);
            }
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_panier_index');
    }

    #[Route(path:'/remove/All/{id}', name:'produit_removeAll')]
    public function removeAll($id, SessionInterface $session){
        //voglio sopprimere un articolo dal paniere
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_panier_index');
    }

    #[Route(path:'/create', name:'panier_create')]
    public function create(Request $req, SessionInterface $session, ManagerRegistry $doctrine, RestaurantRepository $RestaurantServices, PrototypeProduitRepository $produitRepository){
        
        //$id_resto = $session->get('id_resto');
        $id_resto = $req->request->get('id_resto');

        //recupera solo id_prototypeProdotto e quantita_prototypeProdotto
        $panier = $session->get('panier');
        //$total= $req->request->get('totale');
        $total=0;
        
        $comanda= new Panier();
        $em = $doctrine->getManager(); 
        $comanda->setDatePaiment(new DateTime());
        $resto= $RestaurantServices->find($id_resto);
        $comanda->setRestaurant($resto);
        
        foreach ($panier as $id => $quantity) {
            $detailProduit= new DetailProduitLocation();
            $produit=$produitRepository->find($id);
            $detailProduit->setPrototypeProduit($produit);
            $montant= $quantity * $produit->getPrixLocationUnitaire();
            $detailProduit->setMontant($montant);
            $total+=$montant;
            $detailProduit->setDateDebut(new DateTime());
            $detailProduit->setQuantiteTotal($quantity);
            $detailProduit->setQuantiteResteRendre(0);
            $detailProduit->setMontantParUnite($produit->getPrixLocationUnitaire());
            //$detailProduit->setPanier($comanda);
            
            $comanda->addDetailProduitLocation($detailProduit);
        }

        $em->persist($comanda);
        $em->flush();

        $vars = ['commande' => $comanda,
                'totale'=> $total];
        return $this->render('panier/commande_passer.html.twig', $vars);

    }
    //rimuove dalla sessione il paniere, 
    //é diverso da Remove() perché questa action non lo cancella dalla DB
    #[Route(path:'/remove/inSession', name:'panier_no_inSession')]
    public function removeToSessionThePanier(Request $req, SessionInterface $session, ManagerRegistry $doctrine){
        
        $comande = $session->get('commande');
        //dd($comande);
        $em = $doctrine->getManager();
        $em->persist($comande);
        $em->flush();

        $comanda= new Panier();

        $panier = [];
        $session->set('panier',$panier);
        $session->set('commande',$comanda);
        //return $this->redirectToRoute('app_produit_index');
        return $this->render('panier/commande_noSession.html.twig', [
            'panier'=>$panier,
            'comanda' =>$comanda
        ]);
    }

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PanierRepository $panierRepository): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierRepository->add($panier);
            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, PanierRepository $panierRepository): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierRepository->add($panier);
            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, PanierRepository $panierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $panierRepository->remove($panier);
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }
}
