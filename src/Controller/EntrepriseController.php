<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(ManagerRegistry $docrine): Response
    {

        // gets all the company in db
        $entreprises = $docrine->getRepository(Entreprise::class)->findBy([],["raisonSociale"=>"ASC"]);

        return $this->render('entreprise/index.html.twig', [

            'entreprises'=> $entreprises,
        ]);
    }


    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function showEntreprise(ManagerRegistry $docrine): Response
    {
        
        $entreprise = "";

        return $this->render('entreprise/index.html.twig', [
    
            'entreprise'=> $entreprise,
        ]);
    }
}
