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
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tenantCountChild;

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

    /**
     * @var ApplicationLabel[]
     * @ORM\ManyToMany(targetEntity="App\Entity\ApplicationLabel")
     */
    private $labels;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status = 0;

    public function __construct()
    {
        $this->applicants = new ArrayCollection();
    }

    /**
     * @return Applicant[]|ArrayCollection
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    public function yearlySalary()
    {
        $income = 0;
        foreach ($this->applicants as $applicant) {
            if ($applicant->getApplicantJob() != null) {
                $income += $applicant->getApplicantJob()->getYearlySalary();
            }
        }
        return $income;
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

    /**
     * @return ApplicationLabel[]|ArrayCollection
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param ApplicationLabel[]|ArrayCollection $labels
     */
    public function setLabels(array $labels)
    {
        dump($this->labels);
        $this->labels = $labels;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getTenantCountChild()
    {
        return $this->tenantCountChild;
    }

    /**
     * @param int $tenantCountChild
     */
    public function setTenantCountChild(int $tenantCountChild)
    {
        $this->tenantCountChild = $tenantCountChild;
    }

    /**
     * @return Application
     */
    public function deepClone()
    {
        $clone = new Application();
        // TODO: deep clone application
        return $clone;
    }
}
