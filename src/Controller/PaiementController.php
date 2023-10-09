<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Paydunya\Setup;
use Paydunya\Checkout\Store;
use Paydunya\Checkout\CheckoutInvoice;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'app_paiement')]
    public function index(): Response
    {
        
        Setup::setMasterKey("F6O2BcA4-MxVD-1C5c-eMjI-I4bsYfpgMqU5");
        Setup::setPublicKey("test_public_H6I4U9rgUzS8jF8YWydxqC1dovG");
        Setup::setPrivateKey("test_private_exRxLNuLpT3JErnZcCM9ZvZgA9E");
        Setup::setToken("mZbn9yAN0wfJ8EhCHvmr");
        Setup::setMode("test"); // Optionnel en mode test. Utilisez cette option pour les paiements tests.
       //Configuration des informations de votre service/entreprise
     
       
        Store::setName("Magasin Chez Sandra"); // Seul le nom est requis
        Store::setTagline("L'élégance n'a pas de prix");
        Store::setPhoneNumber("336530583");
        Store::setPostalAddress("Dakar Plateau - Etablissement kheweul");
        Store::setWebsiteUrl("http://www.chez-sandra.sn");
        Store::setLogoUrl("http://www.chez-sandra.sn/logo.png");


        Store::setCallbackUrl("http://magasin-le-choco.com/callback_url.php");
       
        $invoice = new CheckoutInvoice();
        $invoice->setCallbackUrl("http://magasin-le-choco.com/callback_url.php");


        $invoice->setDescription("Optional Description");
        $invoice->setTotalAmount(1000);

//A insérer dans le fichier du code source qui doit effectuer l'action

// Le code suivant décrit comment créer une facture de paiement au niveau de nos serveurs,
// rediriger ensuite le client vers la page de paiement
// et afficher ensuite son reçu de paiement en cas de succès.
        if($invoice->create()) {
           //dd( $invoice->getInvoiceUrl());
           $data = ["success"=> true,
           "mode" => "test",
           "token"=> $invoice->token];

          return  new JsonResponse($data);
           
        }else{
            echo $invoice->response_text;
    }

    //  return $this->render('paiement/index.html.twig', [
    //        'controller_name' => 'PaiementController',
   //     ]);
    }

    #[Route('paiement/facture', name: 'app_paiement_facture')]
    public function facture(){


        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }

    
}
