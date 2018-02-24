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
use App\Entity\Traits\IdTrait;
use App\Helper\DateTimeFormatter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application extends BaseEntity
{
    use IdTrait;

    /**
     * @var Applicant[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Applicant", mappedBy="application", cascade={"persist", "remove"})
     */
    private $applicants;

    /**
     * @var ApplicationSlot
     * @ORM\ManyToOne(targetEntity="App\Entity\ApplicationSlot", inversedBy="applications")
     */
    private $applicationSlot;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $pets;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $instruments;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="App\Entity\FrontendUser", inversedBy="applications")
     */
    private $frontendUser;

    public function __construct()
    {
        $this->applicants = new ArrayCollection();
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

    /**
     * @return Applicant[]|ArrayCollection
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * @return string
     */
    public function getPets()
    {
        return $this->pets;
    }

    /**
     * @param string $pets
     */
    public function setPets(string $pets): void
    {
        $this->pets = $pets;
    }

    /**
     * @return string
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * @param string $instruments
     */
    public function setInstruments(string $instruments): void
    {
        $this->instruments = $instruments;
    }

    /**
     * @return ApplicationSlot
     */
    public function getApplicationSlot()
    {
        return $this->applicationSlot;
    }

    /**
     * @param ApplicationSlot $applicationSlot
     */
    public function setApplicationSlot(ApplicationSlot $applicationSlot): void
    {
        $this->applicationSlot = $applicationSlot;
    }

    /**
     * @return FrontendUser
     */
    public function getFrontendUser()
    {
        return $this->frontendUser;
    }

    /**
     * @param FrontendUser $frontendUser
     */
    public function setFrontendUser(FrontendUser $frontendUser): void
    {
        $this->frontendUser = $frontendUser;
    }
}
