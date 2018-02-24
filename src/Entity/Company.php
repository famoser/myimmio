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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BackendUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Company extends BaseEntity
{
    use IdTrait;
    use ThingTrait;
    use AddressTrait;

    /**
     * @var BackendUser[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\BackendUser", mappedBy="company")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        return $this->getName();
    }

    /**
     * @return BackendUser[]|ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
