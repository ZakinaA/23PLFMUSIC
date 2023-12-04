<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableModifierType;
use App\Form\ResponsableType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResponsableController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('responsable/index.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }
    public function consulterResponsable(ManagerRegistry $doctrine, int $id){

        $responsable= $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException(
                'Aucun responsable trouvé avec le numéro '.$id
            );
        }

        return $this->render('responsable/consulter.html.twig', [
            'responsable' => $responsable,]);
    }
    public function listerResponsable(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Responsable::class);


        $responsables = $repository->findAll();

        return $this->render('responsable/lister.html.twig', [
            'responsables' => $responsables,
        ]);
    }
    public function ajouterResponsable(ManagerRegistry $doctrine,Request $request){
        $responsable = new responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $responsable = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->render('responsable/consulter.html.twig', ['responsable' => $responsable,]);
        }
        else
        {
            return $this->render('responsable/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
    public function modifierResponsable(ManagerRegistry $doctrine, $id, Request $request){

        //récupération du responsable dont l'id est passé en paramètre
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ResponsableModifierType::class, $responsable);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $responsable = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($responsable);
                $entityManager->flush();
                return $this->render('responsable/consulter.html.twig', ['responsable' => $responsable,]);
            }
            else{
                return $this->render('responsable/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
    public function supprimerResponsable(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $responsable = $entityManager->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro '.$id);
        }

        // Suppression d'un responsable
        $entityManager->remove($responsable);
        $entityManager->flush();

        // Redirection vers la liste des cours après suppression
        return $this->redirectToRoute('responsableLister');
    }
}
