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
use App\Entity\Traits\UserTrait;
use App\Helper\DateTimeFormatter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application extends BaseEntity
{
    use IdTrait;

    /*
     * Applicants
     */

    /**
     * @var Applicant
     * @ORM\OneToMany(targetEntity="Applicant", mappedBy="application")
     */
    private $applicants;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tenantCountAdult;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tenantCountChild;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $pet;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $playInstrument;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $garage;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carPark;

    /**
     * @return Applicant
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * @return int
     */
    public function getTenantCountAdult()
    {
        return $this->tenantCountAdult;
    }

    /**
     * @return int
     */
    public function getTenantCountChild()
    {
        return $this->tenantCountChild;
    }

    /**
     * @return string
     */
    public function getPet()
    {
        return $this->pet;
    }

    /**
     * @return string
     */
    public function getPlayInstrument()
    {
        return $this->playInstrument;
    }

    /**
     * @return bool
     */
    public function isGarage()
    {
        return $this->garage;
    }

    /**
     * @return bool
     */
    public function isCarPark()
    {
        return $this->carPark;
    }

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        return $this->createdAt->format(DateTimeFormatter::DATE_TIME_FORMAT);
    }
}
