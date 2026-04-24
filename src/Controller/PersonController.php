<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/person/add', name: 'app_add_person')]
    public function add(): Response
    {
        $person = new Person();
        $person->setName("salma");
        $person->setAge(25);
        $this->manager->persist($person);
        $person2 = new Person();
        $person2->setName("mohamed");
        $person2->setAge(18);
        $this->manager->persist($person2);
        $this->manager->flush();
        return $this->redirectToRoute('app_person');
    }

    #[Route('/person/delete/{id}', name: 'delete_person')]
    public function deletePerson(Person $person = null): Response
    {
        //$person = $this->personRepository->find($id);
        if (!$person) {
            throw $this->createNotFoundException('Person not found');
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
            throw $this->createNotFoundException('Person not found');
        }
        return $this->render('person/index.html.twig', [
            'persons' => [$person],
        ]);
    }
}
