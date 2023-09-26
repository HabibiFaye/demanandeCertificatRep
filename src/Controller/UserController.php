<?php

namespace App\Controller;


use App\Entity\Demande;
use App\Entity\User;
use App\Form\FormDemandeType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use App\Repository\DemandeRepository;
use Dompdf\Dompdf;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, Request $request): Response
    {
       
        return $this->render('user/index.html.twig', [
            
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemandeRepository $demandeRepository,UserRepository $userRepository): Response
    {
        $user = new User();
        $demande =new Demande();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $demande -> setCreatedAt(new DateTimeImmutable());
            $demande -> setStatutDemande(0);
            $demande -> setStatut("En cours");
            if($demande->isStatutDemande())
                $demande->setStatut("Accepter");
            else
                $demande->setStatut("En cours");

            $user-> addDemande($demande);
            $demande->setLieuReception('RAS');
            $demandeRepository->save($demande, true);

            return $this->render('demande/succes.html.twig', ['user' => $user]);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            
        ]);
    }

   

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/demandepdf', name: 'app_user_demandepdf')]
    public function demandepdf(UserRepository $userRepository){
      //  $user =  $userRepository->findOneById(11);;
        $html =  $this->renderView('user/demandepdf.html.twig');
        $dompdf = new Dompdf();
        $dompdf->loadHtml('bla bla bla');
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        $dompdf->output();
        $dompdf->stream('demande.pdf',[
            "Attachment"=>false
        ]);    
        
    }
}
