<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

#[Route('/')]
class Controller extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry)
    {
    }

    #[Route('', name: 'home')]
    public function index(): Response
    {
        $postregister = $this->registry->getRepository(Post::class);
        $posts = $postregister->findA();

        return $this->render('layout/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
