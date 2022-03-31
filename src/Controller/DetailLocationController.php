<?php

namespace App\Controller;

use App\Entity\DetailProduitLocation;
use App\Form\DetailProduitLocationType;
use App\Repository\DetailProduitLocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/detail/location')]
class DetailLocationController extends AbstractController
{
    #[Route('/', name: 'app_detail_location_index', methods: ['GET'])]
    public function index(DetailProduitLocationRepository $detailProduitLocationRepository): Response
    {
        return $this->render('detail_location/index.html.twig', [
            'detail_produit_locations' => $detailProduitLocationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_detail_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DetailProduitLocationRepository $detailProduitLocationRepository): Response
    {
        $detailProduitLocation = new DetailProduitLocation();
        $form = $this->createForm(DetailProduitLocationType::class, $detailProduitLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailProduitLocationRepository->add($detailProduitLocation);
            return $this->redirectToRoute('app_detail_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detail_location/new.html.twig', [
            'detail_produit_location' => $detailProduitLocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detail_location_show', methods: ['GET'])]
    public function show(DetailProduitLocation $detailProduitLocation): Response
    {
        return $this->render('detail_location/show.html.twig', [
            'detail_produit_location' => $detailProduitLocation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detail_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetailProduitLocation $detailProduitLocation, DetailProduitLocationRepository $detailProduitLocationRepository): Response
    {
        $form = $this->createForm(DetailProduitLocationType::class, $detailProduitLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailProduitLocationRepository->add($detailProduitLocation);
            return $this->redirectToRoute('app_detail_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detail_location/edit.html.twig', [
            'detail_produit_location' => $detailProduitLocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detail_location_delete', methods: ['POST'])]
    public function delete(Request $request, DetailProduitLocation $detailProduitLocation, DetailProduitLocationRepository $detailProduitLocationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailProduitLocation->getId(), $request->request->get('_token'))) {
            $detailProduitLocationRepository->remove($detailProduitLocation);
        }

        return $this->redirectToRoute('app_detail_location_index', [], Response::HTTP_SEE_OTHER);
    }
}
