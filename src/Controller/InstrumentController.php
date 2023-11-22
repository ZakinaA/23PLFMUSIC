<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Instrument;
use Doctrine\ORM\EntityManagerInterface;
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

        //return new Response('Instrument : '.$instruments->getNumSerie());
        return $this->render('instrument/consulterInstrument.html.twig', [
            'instruments' => $instruments,]);
    }



}
