<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Base\BaseEntity;
use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\ThingTrait;
use App\Entity\Traits\UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FrontendUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Building extends BaseEntity
{
    use IdTrait;
    use ThingTrait;
    use AddressTrait;

    /**
     * @var Apartment[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Apartment", mappedBy="building")
     */
    private $apartments;

    public function __construct()
    {
        $this->apartments = new ArrayCollection();
    }

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        return $this->name;
    }

    /**
     * @return Apartment[]|ArrayCollection
     */
    public function getApartments()
    {
        return $this->apartments;
    }
}
