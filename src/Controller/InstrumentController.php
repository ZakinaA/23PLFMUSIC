<?php

namespace App\Controller;

use App\Entity\Instrument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends AbstractController
{

    public function listerInstrument(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Instrument::class);

        $instruments= $repository->findAll();
        return $this->render('instrument/listerInstrument.html.twig', [
            'pInstruments' => $instruments,]);

    }

    #[Route('/instrument', name: 'app_instrument')]
    public function index(): Response
    {
        return $this->render('instrument/index.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }


}
