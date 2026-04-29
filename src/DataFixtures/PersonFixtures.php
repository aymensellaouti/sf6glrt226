<?php

namespace App\DataFixtures;

use App\Entity\Identifier;
use App\Entity\Person;
use App\Entity\Profile;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            $skill = new Skill();
            $skill->setDesignation($faker->jobTitle());
            $manager->persist($skill);
        }
        $manager->flush();
        for ($i = 1; $i <= 100; $i++) {
            $identifier = new Identifier();
            $identifier->setName($i % 2 ?"cin $i":"passeport $i")
                        ->setValue($faker->numberBetween(10000000, 99999999));
            $manager->persist($identifier);
        }
        $manager->flush();
        for($i = 1; $i <= 10; $i++) {
            $profile = new Profile();
            $profile->setDesignation("Profile $i");
            $manager->persist($profile);
        }
        $manager->flush();
        $skills = $manager->getRepository(Skill::class)->findAll();
        $identifiers = $manager->getRepository(Identifier::class)->findAll();
        for ($i = 1; $i <= 10; $i++) {
            $person = new Person();
            $person->setName($faker->name())
                   ->setAge($faker->numberBetween(18, 60))
            ;
            for($j = 1; $j <= 3; $j++) {
                $person->addSkill($skills[$j]);
            }
            $person->setIdentifier($identifiers[$i]);
            $manager->persist($person);
        }
        // $manager->persist($product);
        $manager->flush();
    }
}
