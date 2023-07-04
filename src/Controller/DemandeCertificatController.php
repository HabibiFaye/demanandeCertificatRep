<?php

namespace App\Controller;

use App\Entity\DemandeCertificat;
use App\Entity\User;
use App\Form\DemandeCertificatType;
use App\Repository\DemandeCertificatRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demande/certificat')]
class DemandeCertificatController extends AbstractController
{
    #[Route('/', name: 'app_demande_certificat_index', methods: ['GET'])]

    public function index(DemandeCertificatRepository $demandeCertificatRepository): Response
    {
        return $this->render('demande_certificat/index.html.twig', [
            'demande_certificats' => $demandeCertificatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_demande_certificat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemandeCertificatRepository $demandeCertificatRepository): Response
    {
        $user = new User;
        $demandeCertificat = new DemandeCertificat();
        $demandeCertificat -> setCreatedAt(new DateTimeImmutable());
        $demandeCertificat -> setStatutDemande(0);

        $form = $this->createForm(DemandeCertificatType::class, $demandeCertificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeCertificatRepository->save($demandeCertificat, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_certificat/new.html.twig', [
            'demande_certificat' => $demandeCertificat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_certificat_show', methods: ['GET'])]
    public function show(DemandeCertificat $demandeCertificat): Response
    {

        return $this->render('demande_certificat/show.html.twig', [
            'demande_certificat' => $demandeCertificat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_certificat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DemandeCertificat $demandeCertificat, DemandeCertificatRepository $demandeCertificatRepository): Response
    {
        $form = $this->createForm(DemandeCertificatType::class, $demandeCertificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeCertificatRepository->save($demandeCertificat, true);

            return $this->redirectToRoute('app_demande_certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_certificat/edit.html.twig', [
            'demande_certificat' => $demandeCertificat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_certificat_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeCertificat $demandeCertificat, DemandeCertificatRepository $demandeCertificatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeCertificat->getId(), $request->request->get('_token'))) {
            $demandeCertificatRepository->remove($demandeCertificat, true);
        }

        return $this->redirectToRoute('app_demande_certificat_index', [], Response::HTTP_SEE_OTHER);
    }
}