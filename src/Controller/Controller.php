<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/')]
class Controller extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry, protected UserPasswordHasherInterface $passwordEncoder)
    {
    }

    #[Route('', name: 'home')]
    public function index(): Response
    {
        $postregister = $this->registry->getRepository(Post::class);
        $posts = $postregister->findPostWithLimit(3);

        return $this->render('layout/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
