<?php

namespace App\Controller;

use App\Entity\Accessoire   ;

use App\Entity\Instrument;
use App\Form\AccessoireModifierType;
use App\Form\AccessoireType;
use App\Form\InstrumentModifierType;
use App\Form\InstrumentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class AccessoireController extends AbstractController
{



    //#[Route('/accessoire', name: 'app_accessoire')]
    public function index(): Response
    {
        return $this->render('accessoire/index.html.twig', [
            'controller_name' => 'AccessoireController',
        ]);
    }

    #[Route('/accessoire/consulter/{id}', name: 'app_accessoire')]
    #[ParamConverter('accessoire', class: 'App\Entity\Accessoire')]
    public function consulter(ManagerRegistry $doctrine, int $id)
    {

        $accessoires = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoires) {
            throw $this->createNotFoundException(
                'Aucun accessoire trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Accessoire : '.$accessoire->getId());
        return $this->render('accessoire/consulterAccessoire.html.twig', [
            'accessoires' => $accessoires,]);
    }

    public function listerAccessoire(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Accessoire::class);


        $accessoires = $repository->findAll();

        return $this->render('accessoire/listerAccessoire.html.twig', [
            'accessoires' => $accessoires,
        ]);
    }

    public function ajouterAccessoire(ManagerRegistry $doctrine,Request $request){
        $accessoire = new accessoire();
        $form = $this->createForm(AccessoireType::class, $accessoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $accessoire = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($accessoire);
            $entityManager->flush();

            return $this->render('accessoire/consulterAccessoire.html.twig', ['accessoires' => $accessoire,]);
        }
        else
        {
            return $this->render('accessoire/ajouterAccessoire.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierAccessoire(ManagerRegistry $doctrine, $id, Request $request){

        //récupération de l'accessoire dont l'id est passé en paramètre
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(AccessoireModifierType::class, $accessoire);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $accessoire = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($accessoire);
                $entityManager->flush();
                return $this->render('accessoire/consulterAccessoire.html.twig', ['accessoires' => $accessoire,]);
            }
            else{
                return $this->render('accessoire/ajouterAccessoire.html.twig', array('form' => $form->createView(),));
            }
        }
    }

    public function supprimerAccessoire(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $accessoire = $entityManager->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvé avec le numéro '.$id);
        }

        // Suppression de l accessoire
        $entityManager->remove($accessoire);
        $entityManager->flush();

        // Redirection vers la liste des accessoire après suppression
        return $this->redirectToRoute('accessoireLister');
    }



}
