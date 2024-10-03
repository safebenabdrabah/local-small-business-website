<?php

namespace App\Controller;

use App\Entity\SmallBusiness;
use App\Repository\SmallBusinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmallbusinessreadingController extends AbstractController
{
    #[Route('/smallbusinessreading/{id}', methods:['GET'], name: 'app_smallbusinessreading')]
    public function index(int $id , SmallBusinessRepository $smallBusinessRepository): Response
    {
        $smallBusiness=$smallBusinessRepository->find($id);

        return $this->render('smallbusinessreading/index.html.twig', [
            'controller_name' => 'SmallbusinessreadingController',
            'smallBusiness'=>$smallBusiness,
        ]);
    }
}
