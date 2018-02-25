<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\DataFixtures\Base\BaseFixture;
use App\Entity\Apartment;
use App\Entity\Applicant;
use App\Entity\ApplicantJob;
use App\Entity\ApplicantLandlord;
use App\Entity\ApplicantReference;
use App\Entity\Application;
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Entity\FrontendUser;
use App\Form\ApplicationSlot\ApplicationSlotType;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Country;

class LoadApplicationData extends BaseFixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     *
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        $frontendUser = $manager->getRepository(FrontendUser::class)->findOneBy(["email" => "info@myimm.io"]);

        for ($i = 0; $i < 20; $i++) {
            $applicationSlot = $manager->getRepository(ApplicationSlot::class)->find(($i % 5) + 1);
            $application = $this->getAllRandomInstance();
            $application->setFrontendUser($frontendUser);
            $application->setApplicationSlot($applicationSlot);

            $manager->persist($application);
        }
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * create an instance with all random values.
     *
     * @return Application
     */
    protected function getAllRandomInstance()
    {
        $faker = $this->getFaker();

        $application = new Application();
        $application->setInstruments($faker->text(30));
        $application->setPets($faker->text(30));
        $application->setTenantCountChild($faker->numberBetween(0, 5));

        for ($i = 0; $i < $faker->numberBetween(0, 5); $i++) {
            $applicant = $this->getApplicantRandomInstance();
            $application->getApplicants()->add($applicant);
            $applicant->setApplication($application);
        }

        return $application;
    }

    /**
     * @return Applicant
     */
    private function getApplicantRandomInstance()
    {
        $faker = $this->getFaker();

        $applicant = new Applicant();
        $this->fillRandomAddress($applicant);
        $this->fillRandomPerson($applicant);
        $this->fillRandomContact($applicant);
        $applicantJob = $this->getApplicantJob();
        $applicant->setApplicantJob($applicantJob);
        $applicantJob->getReference()->setApplicant($applicant);
        $applicant->setCurrentLandlord($this->getLandlord());
        $applicant->setBirthDate($faker->dateTimeThisCentury());
        $applicant->setCivilStatus($faker->text(20));
        $applicant->setNationality("CH");
        $applicant->setResidenceAuthorization("Aufnahmebewilligung C");

        return $applicant;
    }

    /**
     * @return ApplicantLandlord
     */
    private function getLandlord()
    {
        $faker = $this->getFaker();

        $landlord = new ApplicantLandlord();
        $landlord->setReference($this->getApplicantReference());
        $landlord->setNoticeBy("August 2018");
        $landlord->setRelocationReason("Nähe Arbeitsweg");
        $landlord->setRentingSince($faker->dateTimeThisCentury);

        return $landlord;
    }

    /**
     * @return ApplicantJob
     */
    private function getApplicantJob()
    {
        $faker = $this->getFaker();

        $applicantJob = new ApplicantJob();
        $applicantJob->setProfession($faker->jobTitle);
        $applicantJob->setWorkingSince($faker->dateTimeThisCentury);
        $applicantJob->setYearlySalary($faker->numberBetween(10000, 100000));
        $applicantJob->setReference($this->getApplicantReference());

        return $applicantJob;
    }

    /**
     * @return ApplicantReference
     */
    private function getApplicantReference()
    {
        $applicantReference = new ApplicantReference();
        $this->fillRandomThing($applicantReference);
        $this->fillRandomPerson($applicantReference);
        $this->fillRandomContact($applicantReference);

        return $applicantReference;
    }
}
