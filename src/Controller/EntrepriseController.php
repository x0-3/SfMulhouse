<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/entreprise/add', name: 'add_entreprise')]
    public function add(ManagerRegistry $docrine, Entreprise $entreprise = null, Request $request)
    {

        // create a form that refers to the builder in entrepriseType
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            $entreprise = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($entreprise); // prepare
            $entityManager->flush(); // execute

            // redirect to list entreprise
            return $this->redirectToRoute('app_entreprise');
        }

        // vue to show form
        return $this->render('entreprise/add.html.twig', [

            'formAddEntreprise'=> $form->createView(),   
        ]);
    }


    // need to add it at the end 
    // get the page for one id with param {id}
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {

        return $this->render('entreprise/show.html.twig', [
            'entreprise'=> $entreprise,
        ]);
    }
}
