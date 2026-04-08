<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig');
    }

    #[Route('/bonjour/{name}/{firstname}', name: 'app_bonjour')]
    public function bonjour(Request $request, $name, $firstname): Response
    {
        dump($request);

        return $this->render('first/bonjour.html.twig', [
            'name' => $name,
            "firstname" => $firstname
        ]);
    }
    #[Route('/session', name: 'app_session')]
    public function session(SessionInterface $session): Response
    {
        if (!$session->has('nbVisite')) {
            $this->addFlash('happy', 'Première visite :D');
            $session->set('nbVisite', 1);
        } else {
            $session->set('nbVisite', $session->get('nbVisite') + 1);
        }

        return $this->render('first/session.html.twig');
    }
}
