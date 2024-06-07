<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; ++$i) {
            $employee = new Employee();
            $employee->setName($faker->name());
            $manager->persist($employee);
        }

        $manager->flush();
    }
}
