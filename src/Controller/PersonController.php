<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PersonController extends AbstractController
{
    protected ManagerRegistry $doctrine;
    protected ObjectManager $manager;
    protected  PersonRepository $personRepository;
    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->personRepository = $doctrine->getRepository(Person::class);
    }

    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        $persons = $this->personRepository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }

    #[Route('/person/edit/{id?0}', name: 'app_add_person')]
    public function add(Request $request, Person $person = null): Response
    {
        $successMessage = '';
        if(!$person) {
            $person = new Person();
            $successMessage = "La personne a été ajouté avec succès";
        }
        $form = $this->createForm(PersonType::class, $person);
//        $form->remove('age');
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($person);
            $this->manager->flush();
            $successMessage = "La personne a été modifié avec succès";
            $this->addFlash('success', $successMessage);
            return $this->redirectToRoute('app_person');
        }

        return $this->render('person/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[
        Route('/person/delete/{id}', name: 'delete_person'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deletePerson(Person $person = null): Response
    {
        //$person = $this->personRepository->find($id);
        if (!$person) {
            throw $this->createNotFoundException('PersonFixtures not found');
        }
        $this->manager->remove($person);
        $this->manager->flush();
        return $this->redirectToRoute('app_person');
    }
    #[Route('/person/{id}', name: 'details_person')]
    public function detailsPerson(Person $person = null): Response
    {
        //$person = $this->personRepository->find($id);
        if (!$person) {
            throw $this->createNotFoundException('PersonFixtures not found');
        }
        return $this->render('person/index.html.twig', [
            'persons' => [$person],
        ]);
    }
}
