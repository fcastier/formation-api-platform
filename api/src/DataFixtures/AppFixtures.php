<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $companies = [];
        for ($i = 0; $i < 3; ++$i) {
            $company = new Company();
            $company->setName($faker->company());
            $manager->persist($company);
            $companies[] = $company;
        }

        for ($i = 0; $i < 10; ++$i) {
            $employee = new Employee();
            $employee->setName($faker->name());
            if ($faker->boolean(70)) {
                $employee->setCompany($faker->randomElement($companies));
            }
            $manager->persist($employee);
        }

        $manager->flush();
    }
}
