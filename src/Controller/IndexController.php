<?php

namespace App\Controller;

use App\Entity\Eleve;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    public function consulterMentionLégale(): Response
    {

        return $this->render('index/mentionlegale.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
