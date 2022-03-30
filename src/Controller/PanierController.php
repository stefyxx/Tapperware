<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use App\Repository\PrototypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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

    //il paniere é registrato con 3 actions:
    //sono su lista produtti e clicco sul prodotto-> rediretto a panier 'index'
    //riclicco sullo stesso prodotto -> 'add'
    //fleggo affianco -> 'remove' all
    #[Route('/', name: 'app_panier_index')]
    public function index(SessionInterface $session, PrototypeProduitRepository $productRepository ): Response
    {
        //paniere che ha id di prodotto
        $panier =$session->get('panier', []);
        //rifaccio un paniere che ha più di un id e le quantità
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[]=[
                //'id' => $id,
                'product'=>$productRepository->find($id),        //new product()->getReposiroty()->find(id);
                'quantity' => $quantity
            ];
        }

        $total=0;
        foreach ($panierWithData as $item) {
            //totale di 1 prodotto
            $totalItem= $item['product']->getPrixLocationUnitaire() * $item['quantity'];
            //totale di tutto
            $total += $totalItem;
        }

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $panierWithData,
            'totale' => $total
        ]);
    }

    #[Route(path:'/panier/add/{id}', name:'produit_add')]
    public function add($id, SessionInterface $session){
        //$session = $request->getsession();    // non é mpiu' necessario perché ho SessionInterface $session 

        //guarda nella session e cerca 'panier', se non trovi niente (ancora non ho scelto niente), dammi un tab vuoto
        $panier =$session->get('panier', []);

        if (!empty($panier[$id])) {
            //se riclicco sullo stesso prodotto, aumento la quantità
            $panier[$id]+=10;
        } else {
            //se clicco 1 volta sul prodotto, aggiungo quantità 1
            $panier[$id]=10;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_panier_index');
    }

    #[Route(path:'/panier/remove/{id}', name:'produit_remove')]
    public function remove($id, SessionInterface $session){
        //voglio sopprimere un articolo dal paniere
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            //unset($panier[$id]);
            $panier[$id]-=10;
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_panier_index');
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
