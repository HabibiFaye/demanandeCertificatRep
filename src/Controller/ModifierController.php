<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;


class ModifierController extends AbstractController
{
   
    #[Route('/modifier', name: 'app_modifier')]
    public function index(HttpFoundationRequest $request,UserRepository $userrep ): Response
    {
       
      $user = new User();

      $form = $this->createForm(UserType::class, $user);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $nom = $form['nom']->getData();
        dd($nom);
        return $this->render('app_user_show', ['user' => $user]);
    }


      return $this->renderForm('modifier/index.html.twig', [
        'user' => $user,
        'form' => $form,
        
    ]);      
       // return $this->render('modifier/index.html.twig', [
            
       // ]);
        
    }
    #[Route('/show', name: 'app_user_show', methods: ['GET'])]
    public function show(UserRepository $userRepository,Demande $demandeCertificat): Response
    {
        $data = $_REQUEST;
        $dateNaissance = $data['dateNaissance'];
        $user = $userRepository->findOneByDate($dateNaissance);
       
       // dd($data1);
        return $this->render('user/show.html.twig', [
        'user' => $user,
        ]);
    }
}
