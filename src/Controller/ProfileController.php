<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_profile_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,int $id ,UserRepository $userRepository ): Response
    {   
        $user=$userRepository->findOneBy(['id'=>$id]);
        $profile = new Profile();

        $profile->setUser($user);
        $form = $this->createForm(ProfileType::class, $profile);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('profile_pic')->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('image_directory'); // Correct parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
    
                try {
                    $uploadedFile->move($destination, $newFilename);
                    // Set the profile picture path in the entity (store only the filename)
                    $profile->setProfilePic($newFilename);
                } catch (FileException $e) {
                    // Handle file upload error
                    throw new \Exception('Could not upload file');
                }
            }

            $entityManager->persist($profile);
            $entityManager->flush();
            $profileId=$profile->getId();
            return $this->redirectToRoute('app_profile_show', ['id' => $profileId] , Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_show', methods: ['GET'])]
    public function show( int $id, ProfileRepository $profileRepository): Response
    {   
        $smallBusinesses=[];
        $profile= $profileRepository->findOneBy(['id'=>$id]);
       
        $smallBusinesses= $profile->getSmallBusinesses()->getValues();
       
       
        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
            'smallBusinesses' => $smallBusinesses,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Profile $profile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('profile_pic')->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('image_directory'); // Correct parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
    
                try {
                    $uploadedFile->move($destination, $newFilename);
                    $profile->setProfilePic($newFilename);
                } catch (FileException $e) {
                    throw new \Exception('Could not upload file');
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_profile_show', ['id' => $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, Profile $profile, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, SessionInterface $session): Response
    {
        $user=$profile->getUser();
        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {

            $tokenStorage->setToken(null); 
            $session->invalidate();  
            $entityManager->remove($profile);
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
    }
}
