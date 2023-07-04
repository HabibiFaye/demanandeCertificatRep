<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DemandeCertificat;
use App\Entity\User;
use App\Form\FormDemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DemandeController extends AbstractController
{
    
    #[Route('/demande', name: 'app_demande')]
    
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
       
        $demande = new DemandeCertificat();
        $formDemande = $this->createForm(FormDemandeType::class, $demande);
        $formDemande->handleRequest($request);
      
        if ($formDemande->isSubmitted() && $formDemande->isValid()) {

            $demande = $formDemande->getData();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->render('demande/succes.html.twig');
    }

    return $this->render('demande/index.html.twig', [
        'form' => $formDemande->createView(),

    ]);
    }
}
