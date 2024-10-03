<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SmallBusinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmallbussinesesCategoriesController extends AbstractController
{
    #[Route('/smallbussineses/categories/{id}', methods:['GET'],  name: 'app_smallbussineses_categories')]
    public function index(SmallBusinessRepository $smallBusinessesRepo,CategoryRepository $categoryRepository, int $id): Response
    {   
       $smallBusinesses=[];
       $category=$categoryRepository->findOneBy(['id'=> $id]);
      
       $smallBusinesses= $category->getSmallBusinesses()->getValues();
      
      
       return $this->render('smallbussineses_categories/index.html.twig', [
            'smallBusinesses' => $smallBusinesses,
            'category'=>$category,
        ]);
    }
}