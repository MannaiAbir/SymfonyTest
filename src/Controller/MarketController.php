<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MarketRepository;
use App\Form\MarketType;
use App\Entity\Market;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RechercheType;


class MarketController extends AbstractController
{
    #[Route('/market', name: 'app_market')]
    public function index(): Response
    {
        return $this->render('market/index.html.twig', [
            'controller_name' => 'MarketController',
        ]);
    }


    #[Route('/showmarket', name: 'app_showmarket')]
    public function showmarket(MarketRepository $marketrep ,Request $req, ManagerRegistry $manreg): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($req);
        $marketdata = $marketrep->findAll();
        $name=$form->get('search')->getData();
        if ($name) {
            $marketdata = $marketrep->rechercheByName($name);
        }

        
        return $this->render('market/showmarket.html.twig', [
            'markettab' => $marketdata, 'rechercheForm' => $form,
        ]);
    }
   

    #[Route('/editmarket/{id}', name: 'app_editmarket')]
    public function editmarket(Request $req, MarketRepository $marketrep, ManagerRegistry $mreg, $id): Response
    {
        $em = $mreg->getManager();
        $markets = $marketrep->find($id);
        $form = $this->createForm(MarketType::class, $markets);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($markets);
            $em->flush();
            return $this->redirectToRoute('app_showmarket');
        }

        return $this->render('market/editmarket.html.twig', [
            'form' => $form,
        ]);
    }
}
