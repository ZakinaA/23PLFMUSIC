<?php

namespace App\Controller;


use App\Entity\Intervention;
use App\Form\InterventionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InterventionModifierType;




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

    public function ajouterIntervention(ManagerRegistry $doctrine,Request $request){

        $intervention = new intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $intervention = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->render('intervention/consulter.html.twig', ['intervention' => $intervention,]);
        }
        else
        {
            return $this->render('intervention/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierIntervention(ManagerRegistry $doctrine, $id, Request $request){

        //récupération de l'intervention dont l'id est passé en paramètre
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('Aucune intervention trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(InterventionModifierType::class, $intervention);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $intervention = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($intervention);
                $entityManager->flush();
                return $this->render('intervention/consulter.html.twig', ['intervention' => $intervention,]);
            }
            else{
                return $this->render('intervention/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}
