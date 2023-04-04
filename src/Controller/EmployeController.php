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
        // gets all the company in db
        $employes = $docrine->getRepository(Employe::class)->findAll();

        return $this->render('employe/index.html.twig', [

            'employes'=> $employes,
        ]);
    }
}
