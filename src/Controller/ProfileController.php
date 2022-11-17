<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Form\PostType;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/{id}', name: 'app_profile')]
    public function index(User $user): Response
    {
       $posts = $user->getPosts()->getValues();
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'posts' => $posts,
        ]);

    }
    #[Route('/edit/{id}', name: 'app_profile_edit')]
    public function editPostUser(Request $request, Post $post, PostRepository $userRepo) 
    {
        if($post->getAuthor()->getEmail() == $this->getUser()->getUserIdentifier()) {
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $userRepo->save($post, true);
                return $this->redirectToRoute('app_profile', ['id' => $post->getAuthor()->getId()]);
            }
        }
        return $this->render('layout/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
        
    }
}
