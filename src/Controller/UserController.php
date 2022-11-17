<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry, protected UserPasswordHasherInterface $passwordEncoder)
    {
    }

    #[Route('/', name: 'app_user_index')]
    public function index(): Response
    {
        $userRegister = $this->registry->getRepository(User::class);
        $users = $userRegister->findAll();
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    #[Route('/create', name: 'app_user_create')]
    public function create(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));

            $u = $this->registry->getManager();
            $u->persist($user);
            $u->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
    #[Route('edit/{id}', name: 'app_user_edit')]
    public function edit(Request $request, $id): Response
    {
        $userRegister = $this->registry->getRepository(User::class);
        $user = $userRegister->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));

            $u = $this->registry->getManager();
            $u->persist($user);
            $u->flush();

            return $this->redirectToRoute('accueil');
        }
        

            
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
