<?php

namespace App\Controller;


use App\Entity\Eleve;
use App\Form\EleveModifierType;
use App\Form\EleveType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }
    public function consulterEleve(ManagerRegistry $doctrine, int $id){

        $eleve= $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException(
                'Aucun eleve trouvé avec le numéro '.$id
            );
        }

        return $this->render('eleve/consulter.html.twig', [
            'eleve' => $eleve,]);
    }
    public function listerEleve(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Eleve::class);


        $eleves = $repository->findAll();

        return $this->render('eleve/lister.html.twig', [
            'eleves' => $eleves,
        ]);
    }
    public function ajouterEleve(ManagerRegistry $doctrine,Request $request){
        $eleve = new eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eleve = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve,]);
        }
        else
        {
            return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
    public function modifierEleve(ManagerRegistry $doctrine, $id, Request $request){

        //récupération du eleve dont l'id est passé en paramètre
        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucun eleve trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(EleveModifierType::class, $eleve);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $eleve = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($eleve);
                $entityManager->flush();
                return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve,]);
            }
            else{
                return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
    public function supprimerEleve(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $eleve = $entityManager->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucun eleve trouvé avec le numéro '.$id);
        }

        // Suppression d'un eleve
        $entityManager->remove($eleve);
        $entityManager->flush();

        // Redirection vers la liste des cours après suppression
        return $this->redirectToRoute('eleveLister');
    }

}
