<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class PersonController extends AbstractController
{

    protected ObjectManager $manager;
    protected PersonRepository $presonRepository;
    public function __construct(protected ManagerRegistry $doctrine) {
        $this->manager = $this->doctrine->getManager();
        $this->presonRepository = $this->doctrine->getRepository(Person::class);
    }

    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        $persons = $this->presonRepository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }


    #[Route('/person/add', name: 'app_add_person')]
    public function add(): Response
    {
        $person = new Person();
        $person->setName('mariem');
        $person->setAge(20);
        $this->manager->persist($person);
        $person2 = new Person();
        $person2->setName('skander');
        $person2->setAge(20);
        $this->manager->persist($person2);
        $this->manager->flush();
        $this->addFlash('success', 'Person added successfully');
        return $this->redirectToRoute('app_person');
    }

    #[Route('/person/{id}', name: 'details_person')]
    public function details(Person $person = null): Response
    {
        //$person = $this->presonRepository->find($id);
        if(!$person) {
            throw new NotFoundHttpException('Person not found');
        }
        return $this->render('person/index.html.twig', [
            'persons' => [$person],
        ]);
    }

    #[Route('/person/remove/{id}', name: 'remove_person')]
    public function remove(Person $person = null): Response
    {
        if(!$person) {
            throw new NotFoundHttpException('Person not found');
        }
        $this->manager->remove($person);
        $this->manager->flush();
        $this->addFlash('success', 'Person Removed');
        return $this->redirectToRoute('app_person');
    }
}
