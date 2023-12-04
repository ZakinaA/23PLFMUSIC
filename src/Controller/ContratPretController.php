<?php

namespace App\Controller;

use App\Entity\ContratPret;
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

}

