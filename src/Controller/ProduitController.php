<?php

namespace App\Controller;

use App\Entity\PrototypeProduit;
use App\Form\PrototypeProduitType;
use App\Repository\CategoryRepository;
use App\Repository\PrototypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(PrototypeProduitRepository $prototypeProduitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'prototype_produits' => $prototypeProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrototypeProduitRepository $prototypeProduitRepository, CategoryRepository $categoryService): Response
    {   //aggiungere select delle Category-> fatto con Form->PrototypeProduitType.php -> cosi' é in tutte le actions
        $allCategory= $categoryService->findAll();

        $prototypeProduit = new PrototypeProduit();
        
        //aggiungere action et method
        $form = $this->createForm(PrototypeProduitType::class, $prototypeProduit,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prototypeProduitRepository->add($prototypeProduit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'prototype_produit' => $prototypeProduit,
            'allCategoty' => $allCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(PrototypeProduit $prototypeProduit): Response
    {
        return $this->render('produit/show.html.twig', [
            'prototype_produit' => $prototypeProduit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PrototypeProduit $prototypeProduit, PrototypeProduitRepository $prototypeProduitRepository): Response
    {
        $form = $this->createForm(PrototypeProduitType::class, $prototypeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prototypeProduitRepository->add($prototypeProduit);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'prototype_produit' => $prototypeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, PrototypeProduit $prototypeProduit, PrototypeProduitRepository $prototypeProduitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prototypeProduit->getId(), $request->request->get('_token'))) {
            $prototypeProduitRepository->remove($prototypeProduit);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
