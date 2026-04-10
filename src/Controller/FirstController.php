<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FirstController extends AbstractController
{

    #[Route("/", name: 'app_home')]
    public function home ()
    {
        return $this->render('base.html.twig');
    }
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig');
    }

    #[Route('/notes/{nb?5}', name: 'app_note')]
    public function notes($nb): Response
    {
        $notes = [];
        for($i=0; $i<$nb;$i++) {
            $notes[$i] = rand(0,20);
        }
        return $this->render('first/notes.html.twig', [
            'notes' => $notes
        ]);
    }
}
