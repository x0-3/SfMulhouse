<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response
    {

        return $this->render('employe/show.html.twig', [
            'employe'=> $employe,
        ]);
    }
}
