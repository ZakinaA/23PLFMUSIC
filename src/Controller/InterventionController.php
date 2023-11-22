<?php

namespace App\Controller;

use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterventionController extends AbstractController
{
    #[Route('/intervention', name: 'app_intervention')]
    public function index(): Response
    {
        return $this->render('intervention/index.html.twig', [
            'controller_name' => 'InterventionController',
        ]);
    }
    public function consulterIntervention(ManagerRegistry $doctrine, int $id){

        $Intervention= $doctrine->getRepository(Intervention::class)->find($id);

        if (!$Intervention) {
            throw $this->createNotFoundException(
                'Aucune intervention trouvé avec le numéro '.$id
            );
        }
        //return new Response('Intervention : '.$Intervention->getid());
        return $this->render('Intervention/consulter.html.twig', [
            'intervention' => $Intervention,]);
    }
    public function listerIntervention(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(intervention::class);

        $interventions= $repository->findAll();
        return $this->render('intervention/lister.html.twig', [
            'pinterventions' => $interventions,]);
    }
}
