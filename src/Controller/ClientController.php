<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClientRepository;
use App\Form\ClientType;
use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;



class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/showclient', name: 'app_showclient')]
    public function showclient(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();
        return $this->render('client/showclient.html.twig', [
            'clienttab' => $clients,
        ]);
    }
    #[Route('/addclient', name: 'app_addclient')]
    public function addclient(Request $request, ManagerRegistry $managerRegistry, ClientRepository $clientRepository): Response
    {
        $em=$managerRegistry->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('app_showclient');
            }
            return $this->render('client/addclient.html.twig', [
                'addclient' => $form ,
                

        ]);
    }
    #[Route('/deleteclient/{id}', name: 'app_deleteclient')]
    public function deleteclient($id, ManagerRegistry $managerRegistry, ClientRepository $clientRepository): Response
    {
        $em=$managerRegistry->getManager();
        $client = $clientRepository->Find($id);
        $em->remove($client);
        $em->flush();
        return $this->redirectToRoute('app_showclient');
    }


}  
