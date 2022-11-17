<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class PostController extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry)
    {
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $postregister = $this->registry->getRepository(Post::class);
        $posts = $postregister->findAll();
        $postIndex = true;

        return $this->render('layout/index.html.twig', [
            'posts' => $posts,
            'postIndex' => $postIndex,
        ]);
    }

    #[Route('/post/{id}', name: 'get_post')]
    public function getPost($id): Response
    {

        $postregister = $this->registry->getRepository(Post::class);
        $post = $postregister->find($id);
        return $this->render('layout/post.html.twig', [
            'post' => $post,
        ]);
    }
    #[Route('/create', name: 'create_post')]
    public function setPost(Request $request) 
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $currentUser = $this->getUser();
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuthor($currentUser);
            $p = $this->registry->getManager();
            $p->persist($post);
            $p->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('layout/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/edit/{id}', name: 'edit_post')]

public function editPost(Request $request, $id, PostRepository $postRepository) 
    {
        $postregister = $this->registry->getRepository(Post::class);
        $post = $postregister->find($id);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $postRepository->save($post, true);

            return $this->redirectToRoute('accueil');
        }
        return $this->render('layout/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_post')]
    public function deletePost($id) 
    {
        $postregister = $this->registry->getRepository(Post::class);
        $post = $postregister->find($id);

        $p = $this->registry->getManager();
        $p->remove($post);
        $p->flush();

        return $this->redirectToRoute('accueil');
    }
}
