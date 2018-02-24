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
use App\Entity\Traits\ContactTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\PersonTrait;
use App\Helper\DateTimeFormatter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Applicant extends BaseEntity
{
    use IdTrait;
    use PersonTrait;
    use AddressTrait;
    use ContactTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $salutation;

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
     * @Assert\Country()
     */
    private $nationality = 'CH';

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $residenceAuthorization;

    /**
     * @var ApplicantJob
     * @ORM\OneToOne(targetEntity="ApplicantJob", cascade={"persist", "remove"})
     */
    private $applicantJob;

    /**
     * @var ApplicantLandlord
     * @ORM\OneToOne(targetEntity="ApplicantLandlord", cascade={"persist", "remove"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $currentLandlord;

    /**
     * @var Application
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="applicants")
     */
    private $application;

    /**
     * @var ApplicantReference[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="ApplicantReference", mappedBy="applicant", cascade={"persist", "remove"})
     */
    private $references;

    /**
     * Applicant constructor.
     */
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
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
    public function setBirthDate(\DateTime $birthDate): void
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
    public function setCivilStatus(string $civilStatus): void
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
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }

    /**
     * @return ApplicantJob
     */
    public function getApplicantJob()
    {
        return $this->applicantJob;
    }

    /**
     * @param ApplicantJob $applicantJob
     */
    public function setApplicantJob(ApplicantJob $applicantJob): void
    {
        $this->applicantJob = $applicantJob;
    }

    /**
     * @return ApplicantLandlord
     */
    public function getCurrentLandlord()
    {
        return $this->currentLandlord;
    }

    /**
     * @param ApplicantLandlord $currentLandlord
     */
    public function setCurrentLandlord(ApplicantLandlord $currentLandlord): void
    {
        $this->currentLandlord = $currentLandlord;
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
    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    /**
     * @return ApplicantReference[]|ArrayCollection
     */
    public function getReferences()
    {
        return $this->references;
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
}
