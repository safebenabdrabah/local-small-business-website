<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController extends AbstractController
{
    #[Route('/firstpage', name: 'app_first_page')]
    public function index(): Response
    {
        return $this->render('first_page/firstpage.html.twig', [
            'controller_name' => 'FirstPageController',
        ]);
    }
}
