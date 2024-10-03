<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\SmallBusiness;
use App\Form\SmallBusiness1Type;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SmallBusinessRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/small/business')]
class SmallBusinessController extends AbstractController
{
    #[Route('/', name: 'app_small_business_index', methods: ['GET'])]
    public function index(SmallBusinessRepository $smallBusinessRepository): Response
    {
        return $this->render('small_business/index.html.twig', [
            'small_businesses' => $smallBusinessRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_small_business_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,int $id): Response
    {   
        $profile = $entityManager->getRepository(Profile::class)->find($id);

        $smallBusiness = new SmallBusiness();

        if ($profile) {
            $smallBusiness->setProfile($profile);
        } else {
            throw $this->createNotFoundException('Profile not found');
        }
        
        $form = $this->createForm(SmallBusiness1Type::class, $smallBusiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($smallBusiness);
            $entityManager->flush();

            return $this->redirectToRoute('app_small_business_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('small_business/new.html.twig', [
            'small_business' => $smallBusiness,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_small_business_show', methods: ['GET'])]
    public function show(SmallBusiness $smallBusiness): Response
    {
        return $this->render('small_business/show.html.twig', [
            'small_business' => $smallBusiness,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_small_business_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SmallBusiness $smallBusiness, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SmallBusiness1Type::class, $smallBusiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_small_business_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('small_business/edit.html.twig', [
            'small_business' => $smallBusiness,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_small_business_delete', methods: ['POST'])]
    public function delete(Request $request, SmallBusiness $smallBusiness, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$smallBusiness->getId(), $request->request->get('_token'))) {
            $entityManager->remove($smallBusiness);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_small_business_index', [], Response::HTTP_SEE_OTHER);
    }
}
