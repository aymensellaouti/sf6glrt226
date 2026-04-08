<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class HelloController extends AbstractController
{
    #[Route('/hello/{name}/{firstname}', name: 'app_hello')]
    public function index($name, $firstname, Request $request): Response
    {
        dump($request);
//        dd($request);
        return $this->render('hello/index.html.twig',
            // data eli bech neb3ethom lel vue
            [
            'name' => $name,
            'firstname' => $firstname,
        ]);
    }

    #[Route('/session', name: 'app_session')]
    public function session(SessionInterface $session): Response
    {
        if(!$session->has('nbVisite')){
            $this->addFlash('happy','Première visite on est heureux de vous accueillir');
            $session->set('nbVisite', 1);
        } else {
            $session->set('nbVisite', $session->get('nbVisite') + 1);
        }
        return $this->render('hello/session.html.twig',);
    }
}
