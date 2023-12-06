<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursModifierType;
use App\Form\CoursType;
use App\Form\TestType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    //#[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',

        ]);

    }
    public function ajouterTest(ManagerRegistry $doctrine,Request $request){
        $cours = new cours();
        $form = $this->createForm(TestType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cours = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
        }
        else
        {
            return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }


}