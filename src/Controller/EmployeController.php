<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $docrine): Response
    {
        // gets all the employe in db
        $employes = $docrine->getRepository(Employe::class)->findBy([], ['nom' => "ASC"]);

        return $this->render('employe/index.html.twig', [

            'employes'=> $employes,
        ]);
    }

    #[Route('/employe/add', name: 'add_employe')]
    #[Route('/employe/{id}/edit', name: 'edit_employe')]
    public function add(ManagerRegistry $docrine, Employe $employe = null, Request $request)
    {

        // if the entreprise id doesn't exist then create it
        if (!$employe) {
            $employe = new Employe();
        }
        // else edit

        // create a form that refers to the builder in employeType
        $form = $this->createForm(EmployeType::class, $employe);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $employe = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($employe); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('app_employe');
        }

        // vue to show form
        return $this->render('employe/add.html.twig', [

            'formAddEmploye'=> $form->createView(),   
            'edit'=> $employe->getId(),   
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(ManagerRegistry $docrine, Employe $employe):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($employe); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_employe');

    }



    
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response
    {

        return $this->render('employe/show.html.twig', [
            'employe'=> $employe,
        ]);
    }
}
