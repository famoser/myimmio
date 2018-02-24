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
use App\Entity\ApplicationLabel;
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Entity\FrontendUser;
use App\Form\ApplicationSlot\ApplicationSlotType;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Country;

class LoadApplicationLabelData extends BaseFixture
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
        foreach ([
                     'Dokumente ausstehend' => 'red',
                     'Chef fragen' => 'blue',
                     'Meeting ausstehend' => 'darkgreen',
                 ] as $name => $color) {
            $applicationLabel = new ApplicationLabel();
            $applicationLabel->setName($name);
            $applicationLabel->setColor($color);

            $manager->persist($applicationLabel);
        }
        $manager->flush();
    }

    /**
     * create an instance with all random values.
     *
     * @return mixed
     */
    protected function getAllRandomInstance()
    {
        $faker = $this->getFaker();
        $applicationLabel = new ApplicationLabel();
        $applicationLabel->setName($faker->text(20));
        $applicationLabel->setColor('#' . $faker->hexColor());
        return $faker;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }
}
