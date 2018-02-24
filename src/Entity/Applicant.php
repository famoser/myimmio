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
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Applicant extends BaseEntity
{
    use IdTrait;
    use AddressTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $relationship;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $familyName;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $givenName;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $civilStatus;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $nationality;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $residenceAuthorization;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     *
     * Betreibung
     */
    private $paymentEnforcement;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $leasingContracts;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var string
     */
    private $leasingRatePerMonth;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $telephoneMobile;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $email;

    /**
     * @var ApplicantEmployer
     * @ORM\OneToOne(targetEntity="ApplicantEmployer")
     */
    private $employer;

    /**
     * @var ApplicantLandlord
     * @ORM\OneToOne(targetEntity="ApplicantLandlord")
     */
    private $oldLandlord;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $relocationReason;

    /**
     * @var Application
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="applicants")
     */
    private $application;

    /**
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $relationship
     */
    public function setRelationship(string $relationship)
    {
        $this->relationship = $relationship;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     */
    public function setFamilyName(string $familyName)
    {
        $this->familyName = $familyName;
    }

    /**
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     */
    public function setGivenName(string $givenName)
    {
        $this->givenName = $givenName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getCivilStatus()
    {
        return $this->civilStatus;
    }

    /**
     * @param string $civilStatus
     */
    public function setCivilStatus(string $civilStatus)
    {
        $this->civilStatus = $civilStatus;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality(string $nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getResidenceAuthorization()
    {
        return $this->residenceAuthorization;
    }

    /**
     * @param string $residenceAuthorization
     */
    public function setResidenceAuthorization(string $residenceAuthorization)
    {
        $this->residenceAuthorization = $residenceAuthorization;
    }

    /**
     * @return bool
     */
    public function isPaymentEnforcement()
    {
        return $this->paymentEnforcement;
    }

    /**
     * @param bool $paymentEnforcement
     */
    public function setPaymentEnforcement(bool $paymentEnforcement)
    {
        $this->paymentEnforcement = $paymentEnforcement;
    }

    /**
     * @return bool
     */
    public function isLeasingContracts()
    {
        return $this->leasingContracts;
    }

    /**
     * @param bool $leasingContracts
     */
    public function setLeasingContracts(bool $leasingContracts)
    {
        $this->leasingContracts = $leasingContracts;
    }

    /**
     * @return string
     */
    public function getLeasingRatePerMonth()
    {
        return $this->leasingRatePerMonth;
    }

    /**
     * @param string $leasingRatePerMonth
     */
    public function setLeasingRatePerMonth(string $leasingRatePerMonth)
    {
        $this->leasingRatePerMonth = $leasingRatePerMonth;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getTelephoneMobile()
    {
        return $this->telephoneMobile;
    }

    /**
     * @param string $telephoneMobile
     */
    public function setTelephoneMobile(string $telephoneMobile)
    {
        $this->telephoneMobile = $telephoneMobile;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return ApplicantEmployer
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param ApplicantEmployer $employer
     */
    public function setEmployer(ApplicantEmployer $employer)
    {
        $this->employer = $employer;
    }

    /**
     * @return ApplicantLandlord
     */
    public function getOldLandlord()
    {
        return $this->oldLandlord;
    }

    /**
     * @param ApplicantLandlord $oldLandlord
     */
    public function setOldLandlord(ApplicantLandlord $oldLandlord)
    {
        $this->oldLandlord = $oldLandlord;
    }

    /**
     * @return string
     */
    public function getRelocationReason()
    {
        return $this->relocationReason;
    }

    /**
     * @param string $relocationReason
     */
    public function setRelocationReason(string $relocationReason)
    {
        $this->relocationReason = $relocationReason;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
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
