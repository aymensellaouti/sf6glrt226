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
    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(Request $request, $name): Response
    {
        dump($request);
        return $this->render('first/hello.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/session', name: 'app_session')]
    public function sessionExample(SessionInterface $session): Response
    {
        if(!$session->has('nbVisite')) {
            $session->set('nbVisite', 1);
            $this->addFlash('success', "C'est lapremière fois que vous nous visiter on est heureux :D");
        } else {
            $session->set('nbVisite', $session->get('nbVisite') + 1);
        }
        return  $this->render('first/session.html.twig');
    }
}
