<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Form\ContratPretModifierType;
use App\Form\ContratPretType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class ContratPretController extends AbstractController
{
    #[Route('/contratPret', name: 'app_contrat_pret')]
    public function index(): Response
    {
        return $this->render('contrat_pret/index.html.twig', [
            'controller_name' => 'ContratPretController',
        ]);
    }

    public function consulterContratPret(ManagerRegistry $doctrine, int $id)
    {

        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException(
                'Aucun Contrat de Pret trouvé avec le numéro ' . $id
            );
        }
        return $this->render('contrat_pret/consulter.html.twig', [
            'contratPret' => $contratPret,]);
    }

    public function listerContratPret(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(ContratPret::class);

        $contratPrets = $repository->findBy([], ['instrument' => 'ASC']);

//        if ($this->isGranted('ROLE_ADMIN',"ROLE_GEST")){

//        }else{

//        }

        return $this->render('contrat_pret/lister.html.twig', [
            'contratPrets' => $contratPrets,
        ]);
    }

    public function ajouterContratPret(ManagerRegistry $doctrine,Request $request){
        $contratPret = new contratPret();
        $form = $this->createForm(ContratPretType::class, $contratPret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contratPret = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contratPret);
            $entityManager->flush();

            return $this->render('contrat_pret/consulter.html.twig', ['contratPret' => $contratPret,]);
        }
        else
        {
            return $this->render('contrat_pret/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
    public function modifierContratPret(ManagerRegistry $doctrine, $id, Request $request){

        //récupération du Contrat de Pret dont l'id est passé en paramètre
        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException('Aucun Contrat de Pret trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ContratPretModifierType::class, $contratPret);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $contratPret = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($contratPret);
                $entityManager->flush();
                return $this->render('contrat_pret/consulter.html.twig', ['contratPret' => $contratPret,]);
            }
            else{
                return $this->render('contrat_pret/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }

}

