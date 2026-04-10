<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


final class HelloController extends AbstractController
{
    #[Route('/hello/{name}/{firstname}/{age<\d{1,2}>}', name: 'app_hello')]
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
        // N7adhrou el data eli bech naffichiwha
        // Traitement
        if(!$session->has('nbVisite')){
            $this->addFlash('happy','Première visite on est heureux de vous accueillir');
            $session->set('nbVisite', 1);
        } else {
            $session->set('nbVisite', $session->get('nbVisite') + 1);
        }

        // Bech neb3eth ngénéri el page avec les données eli 7adhernahom
        return $this->render('hello/session.html.twig',);
        //return $this->json('data');
    }

//    /**
//     * @param SessionInterface $session
//     * @return Response
//     * @Route('/session', name:"app_session2")
//     */
//    public function session2(SessionInterface $session): Response
//    {
//        if(!$session->has('nbVisite')){
//            $this->addFlash('happy','Première visite on est heureux de vous accueillir');
//            $session->set('nbVisite', 1);
//        } else {
//            $session->set('nbVisite', $session->get('nbVisite') + 1);
//        }
//        return $this->render('hello/session.html.twig',);
//    }
}
