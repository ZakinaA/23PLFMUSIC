<?php

namespace App\Controller;



use App\Entity\Instrument;
use App\Form\InstrumentModifierType;
use App\Form\InstrumentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends AbstractController
{

    #[Route('/instrument/lister', name: 'listerInstrument')]
    public function listerInstrument(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Instrument::class);


        $instruments = $repository->findAll();

        return $this->render('instrument/listerInstrument.html.twig', [
            'instruments' => $instruments,
        ]);
    }

    #[Route('/instrument', name: 'app_instrument')]
    public function index(): Response
    {
        return $this->render('instrument/listerInstrument.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }

    #[Route('/instrument/consulter/{id}', name: 'app_instrument')]
    #[ParamConverter('instrument', class: 'App\Entity\Instrument')]
    public function consulter(ManagerRegistry $doctrine, int $id)
    {

        $instruments = $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instruments) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Instrument : '.$instrument->getNumSerie());
        return $this->render('instrument/consulterInstrument.html.twig', [
            'instruments' => $instruments,]);
    }

    public function ajouterInstrument(ManagerRegistry $doctrine,Request $request){
        $instrument = new instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $instrument = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();

            return $this->render('instrument/consulterInstrument.html.twig', ['instruments' => $instrument,]);
        }
        else
        {
            return $this->render('instrument/ajouterInstrument.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierInstrument(ManagerRegistry $doctrine, $id, Request $request){

        //récupération de l'instrument dont l'id est passé en paramètre
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException('Aucun instrument trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(InstrumentModifierType::class, $instrument);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $instrument = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($instrument);
                $entityManager->flush();
                return $this->render('instrument/consulterInstrument.html.twig', ['instruments' => $instrument,]);
            }
            else{
                return $this->render('instrument/ajouterInstrument.html.twig', array('form' => $form->createView(),));
            }
        }
    }


    public function supprimerInstrument(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $instrument = $entityManager->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException('Aucun instrument trouvé avec le numéro '.$id);
        }

        // Suppression du instrument
        $entityManager->remove($instrument);
        $entityManager->flush();

        // Redirection vers la liste des instrument après suppression
        return $this->redirectToRoute('listerInstrument');
    }


}
