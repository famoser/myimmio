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
use App\Entity\Building;
use Doctrine\Common\Persistence\ObjectManager;

class LoadApartmentData extends BaseFixture
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
        $building = $manager->getRepository(Building::class)->findOneBy([]);

        for ($i = 0; $i < 5; $i++) {
            $apartment = $this->getAllRandomInstance();
            $apartment->setBuilding($building);
            $manager->persist($apartment);
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
     * @return Apartment
     */
    protected function getAllRandomInstance()
    {
        $apartment = new Apartment();
        $this->fillRandomThing($apartment);
        return $apartment;
    }
}
