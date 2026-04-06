<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class FirstController extends AbstractController
{
    // ki tal9a URI /first exuti el fonction index
    #[Route('/hello/{name}/{section}', name: 'app_first')]
    public function index(Request $request, $name, $section): Response
    {
        // i7adher el data lel Vue
        // i3ayet lel vue ou iebe3thelha el data
        return $this->render('first/index.html.twig', [
            // Rani bech neb3ethlek propriété esmha name
            'name' => $name,
            'section' => $section
        ]);
    }

    #[Route('/second', name: 'app_second')]
    public function second(SessionInterface $session): Response
    {
        if (!$session->has('nbVisite')) {
            $session->set('nbVisite', 1);
            $this->addFlash('firstVisite', "c'est la première visite");
        } else {
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $session->set('nbVisite', $nbVisite);
        }
        return $this->render('first/nbVisite.html.twig');
    }
}
