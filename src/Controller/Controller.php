<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class Controller extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
