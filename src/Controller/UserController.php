<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\User;
use App\Form\UserType;
use App\Form\FormDemandeType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use App\Repository\DemandeRepository;
use Knp\Snappy\Pdf;





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

        $form1 = $this->createForm(FormDemandeType::class, $demande);
        $form1->handleRequest($request);
        
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
            'form1' =>$form1
            
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

    private Pdf $pdf ;
    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
        
    }
    #[Route('demandepdf/{id}', name: 'app_user_demandepdf')]
    public function demandepdf(UserRepository $userRepository,User $user){
       
        $userR = $userRepository->find( $user->getId());

    $this->pdf->SetOption('enable-local-file-access',true);
    $html = $this->renderView('user/demandepdf.html.twig',[
        'userR' => $userR
    ]);
        $pdfFile = $this->pdf->getOutputFromHtml($html);
        $response = new Response($pdfFile);
        $response->headers->set('Content-Type', 'application/pdf');    
        $response->headers->set('Content-Disposition', 'inline; filename="demande.pdf"');
    return $response;;
    }
}
