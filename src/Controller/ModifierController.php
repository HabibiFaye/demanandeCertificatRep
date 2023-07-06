<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ModifierController extends AbstractController
{
    #[Route('/modifier', name: 'app_modifier')]
    public function index(HttpFoundationRequest $request,UserRepository $userrep ): Response
    {
        $id = $request->query->get('id');
        $idd = $userrep->find($id);
       
        
        return $this->render('modifier/index.html.twig', [
            'idd' =>$idd
            
        ]);
        
    }
}
