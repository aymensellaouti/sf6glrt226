<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ){}
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('aymen@gmail.com')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'user'))
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $user2 = new User();
        $user2->setEmail('admin@gmail.com')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'admin'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user2);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['userGroup'];
    }
}
