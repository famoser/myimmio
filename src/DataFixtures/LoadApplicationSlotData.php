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
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Form\ApplicationSlot\ApplicationSlotType;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class LoadApplicationSlotData extends BaseFixture
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
        $apartment = $manager->getRepository(Apartment::class)->find(1);

        for ($i = 0; $i < 10; $i++) {
            $applicationSlot = $this->getAllRandomInstance();
            $applicationSlot->setApartment($apartment);
            $manager->persist($applicationSlot);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 12;
    }

    /**
     * create an instance with all random values.
     *
     * @return ApplicationSlot
     */
    protected function getAllRandomInstance()
    {
        $faker = $this->getFaker();

        $applicationSlot = new ApplicationSlot();
        $this->fillRandomThing($applicationSlot);
        $applicationSlot->setIdentifier(Uuid::uuid4());
        $applicationSlot->setStartAt($faker->dateTimeThisMonth);
        $applicationSlot->setEndAt($faker->dateTimeBetween($applicationSlot->getStartAt(), '+1 month'));
        $applicationSlot->setWelcomeHeader("Willkommen");
        $applicationSlot->setWelcomeText("Wir danken Ihnen für das Interesse!");
        return $applicationSlot;
    }
}
