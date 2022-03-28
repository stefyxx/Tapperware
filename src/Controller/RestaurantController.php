<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/restaurant')]
class RestaurantController extends AbstractController
{
    //url: /restaurant e tutti gli altri url delle altre azioni iniziano cosi' /restaurant
    
    #[Route('/', name: 'app_restaurant_index', methods: ['GET'])]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        //visualizzo solo i Resto 'attivi', perché non li cancello da DB, li rendo solo inattivi
        $listarResto = $restaurantRepository->findBy(['isActive'=> true]); 
       //$listarResto = $restaurantRepository->findBy(['User'=> $this->getUser()]); 

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $listarResto,
        ]);
    }

    #[Route('/new', name: 'app_restaurant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RestaurantRepository $restaurantRepository): Response
    {
        //$this->getUser()->is_null;
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $restaurant = new Restaurant();
        $restaurant->setUser($this->getUser());
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantRepository->add($restaurant);
            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restaurant_show', methods: ['GET'])]
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_restaurant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //$restaurant->setUser($this->getUser());   //no, perché se clicco su un resto che non é mio, me lo fa diventare mio
        //e se clicco su un Resto che non é mio?

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantRepository->add($restaurant);
            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }
    //delete visualizza una parzial View, se faccio 'submit, rientro in questa action
    #[Route('/{id}', name: 'app_restaurant_delete', methods: ['POST'])]
    public function delete(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $restaurant->setIsActive(false);
            //$restaurantRepository->remove($restaurant);
            $restaurantRepository->add($restaurant);
        }

        return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
