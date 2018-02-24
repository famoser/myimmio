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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantEmployerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicantJob extends BaseEntity
{
    use IdTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $profession;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearlySalary;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $workingSince;

    /**
     * @var ApplicantReference
     * @ORM\OneToOne(targetEntity="ApplicantReference")
     */
    private $reference;

    /**
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param string $profession
     */
    public function setProfession(string $profession)
    {
        $this->profession = $profession;
    }

    /**
     * @return int
     */
    public function getYearlySalary()
    {
        return $this->yearlySalary;
    }

    /**
     * @param int $yearlySalary
     */
    public function setYearlySalary(int $yearlySalary)
    {
        $this->yearlySalary = $yearlySalary;
    }

    /**
     * @return \DateTime
     */
    public function getWorkingSince()
    {
        return $this->workingSince;
    }

    /**
     * @param \DateTime $workingSince
     */
    public function setWorkingSince(\DateTime $workingSince)
    {
        $this->workingSince = $workingSince;
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
     * @return ApplicantReference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param ApplicantReference $reference
     */
    public function setReference(ApplicantReference $reference): void
    {
        $this->reference = $reference;
    }
}
