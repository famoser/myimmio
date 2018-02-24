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
use App\Entity\BackendUser;
use App\Entity\Building;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBuildingData extends BaseFixture
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
        $backendUser = $manager->getRepository(BackendUser::class)->find(1);

        for ($i = 0; $i < 5; $i++) {
            $builder = $this->getAllRandomInstance();
            $builder->getAdministrators()->add($backendUser);
            $manager->persist($builder);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 11;
    }

    /**
     * create an instance with all random values.
     *
     * @return Building
     */
    protected function getAllRandomInstance()
    {
        $building = new Building();
        $this->fillRandomThing($building);
        $this->fillRandomAddress($building);
        return $building;
    }
}
