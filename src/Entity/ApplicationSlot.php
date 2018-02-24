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
use App\Entity\Traits\ThingTrait;
use App\Enum\FieldDisplayType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * the time frame users can apply & defines how they apply (which fields are optional, what they are welcomed with, ...)
 *
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationSlotRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicationSlot extends BaseEntity
{
    use IdTrait;
    use ThingTrait;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $identifier;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $welcomeHeader;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $welcomeText;

    /**
     * @var Apartment
     * @ORM\ManyToOne(targetEntity="Apartment", inversedBy="applicationSlots")
     */
    private $apartment;

    /*
     * Application
     */

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayTenantCountChild = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayPet = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayPlayInstrument = FieldDisplayType::REQUIRED;

    /*
     * Applicant
     */

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayBirthDate = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayCivilStatus = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayNationality = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayResidenceAuthorization = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayTelephone = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayTelephoneMobile = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayEmail = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayEmployer = FieldDisplayType::REQUIRED;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayCurrentLandlord = FieldDisplayType::REQUIRED;

    /*
     * Reference
     */

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayRelocationReason = FieldDisplayType::REQUIRED;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayNoticeBy = FieldDisplayType::HIDE;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayYearlySalary = FieldDisplayType::REQUIRED;

    /**
     * @var Application[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="applicationSlot")
     */
    private $applications;

    /**
     * ApplicationSlot constructor.
     */
    public function __construct()
    {
        $this->applications = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     */
    public function setStartAt(\DateTime $startAt)
    {
        $this->startAt = $startAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param \DateTime $endAt
     */
    public function setEndAt(\DateTime $endAt)
    {
        $this->endAt = $endAt;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return Apartment
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * @param Apartment $apartment
     */
    public function setApartment(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * @return string
     */
    public function getWelcomeHeader()
    {
        return $this->welcomeHeader;
    }

    /**
     * @param string $welcomeHeader
     */
    public function setWelcomeHeader(string $welcomeHeader)
    {
        $this->welcomeHeader = $welcomeHeader;
    }

    /**
     * @return string
     */
    public function getWelcomeText()
    {
        return $this->welcomeText;
    }

    /**
     * @param string $welcomeText
     */
    public function setWelcomeText(string $welcomeText)
    {
        $this->welcomeText = $welcomeText;
    }

    /**
     * @return int
     */
    public function getDisplayTenantCountChild()
    {
        return $this->displayTenantCountChild;
    }

    /**
     * @param int $displayTenantCountChild
     */
    public function setDisplayTenantCountChild(int $displayTenantCountChild)
    {
        $this->displayTenantCountChild = $displayTenantCountChild;
    }

    /**
     * @return int
     */
    public function getDisplayPet()
    {
        return $this->displayPet;
    }

    /**
     * @param int $displayPet
     */
    public function setDisplayPet(int $displayPet)
    {
        $this->displayPet = $displayPet;
    }

    /**
     * @return int
     */
    public function getDisplayPlayInstrument()
    {
        return $this->displayPlayInstrument;
    }

    /**
     * @param int $displayPlayInstrument
     */
    public function setDisplayPlayInstrument(int $displayPlayInstrument)
    {
        $this->displayPlayInstrument = $displayPlayInstrument;
    }

    /**
     * @return int
     */
    public function getDisplayBirthDate()
    {
        return $this->displayBirthDate;
    }

    /**
     * @param int $displayBirthDate
     */
    public function setDisplayBirthDate(int $displayBirthDate)
    {
        $this->displayBirthDate = $displayBirthDate;
    }

    /**
     * @return int
     */
    public function getDisplayCivilStatus()
    {
        return $this->displayCivilStatus;
    }

    /**
     * @param int $displayCivilStatus
     */
    public function setDisplayCivilStatus(int $displayCivilStatus)
    {
        $this->displayCivilStatus = $displayCivilStatus;
    }

    /**
     * @return int
     */
    public function getDisplayNationality()
    {
        return $this->displayNationality;
    }

    /**
     * @param int $displayNationality
     */
    public function setDisplayNationality(int $displayNationality)
    {
        $this->displayNationality = $displayNationality;
    }

    /**
     * @return int
     */
    public function getDisplayResidenceAuthorization()
    {
        return $this->displayResidenceAuthorization;
    }

    /**
     * @param int $displayResidenceAuthorization
     */
    public function setDisplayResidenceAuthorization(int $displayResidenceAuthorization)
    {
        $this->displayResidenceAuthorization = $displayResidenceAuthorization;
    }

    /**
     * @return int
     */
    public function getDisplayTelephone()
    {
        return $this->displayTelephone;
    }

    /**
     * @param int $displayTelephone
     */
    public function setDisplayTelephone(int $displayTelephone)
    {
        $this->displayTelephone = $displayTelephone;
    }

    /**
     * @return int
     */
    public function getDisplayTelephoneMobile()
    {
        return $this->displayTelephoneMobile;
    }

    /**
     * @param int $displayTelephoneMobile
     */
    public function setDisplayTelephoneMobile(int $displayTelephoneMobile)
    {
        $this->displayTelephoneMobile = $displayTelephoneMobile;
    }

    /**
     * @return int
     */
    public function getDisplayEmail()
    {
        return $this->displayEmail;
    }

    /**
     * @param int $displayEmail
     */
    public function setDisplayEmail(int $displayEmail)
    {
        $this->displayEmail = $displayEmail;
    }

    /**
     * @return int
     */
    public function getDisplayEmployer()
    {
        return $this->displayEmployer;
    }

    /**
     * @param int $displayEmployer
     */
    public function setDisplayEmployer(int $displayEmployer)
    {
        $this->displayEmployer = $displayEmployer;
    }

    /**
     * @return int
     */
    public function getDisplayCurrentLandlord()
    {
        return $this->displayCurrentLandlord;
    }

    /**
     * @param int $displayCurrentLandlord
     */
    public function setDisplayCurrentLandlord(int $displayCurrentLandlord)
    {
        $this->displayCurrentLandlord = $displayCurrentLandlord;
    }

    /**
     * @return int
     */
    public function getDisplayRelocationReason()
    {
        return $this->displayRelocationReason;
    }

    /**
     * @param int $displayRelocationReason
     */
    public function setDisplayRelocationReason(int $displayRelocationReason)
    {
        $this->displayRelocationReason = $displayRelocationReason;
    }

    /**
     * @return int
     */
    public function getDisplayNoticeBy()
    {
        return $this->displayNoticeBy;
    }

    /**
     * @param int $displayNoticeBy
     */
    public function setDisplayNoticeBy(int $displayNoticeBy)
    {
        $this->displayNoticeBy = $displayNoticeBy;
    }

    /**
     * @return int
     */
    public function getDisplayYearlySalary()
    {
        return $this->displayYearlySalary;
    }

    /**
     * @param int $displayYearlySalary
     */
    public function setDisplayYearlySalary(int $displayYearlySalary)
    {
        $this->displayYearlySalary = $displayYearlySalary;
    }

    /**
     * @return Application[]|ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }


}
