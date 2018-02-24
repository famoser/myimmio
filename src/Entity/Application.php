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
     * @ORM\OneToMany(targetEntity="Applicant", mappedBy="application")
     */
    private $applicants;

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
}
