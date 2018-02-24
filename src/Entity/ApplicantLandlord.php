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
class ApplicantLandlord extends BaseEntity
{
    use IdTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $relocationReason;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $rentingSince;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $noticeBy;

    /**
     * @var ApplicantReference
     * @ORM\OneToOne(targetEntity="ApplicantReference", cascade={"persist", "remove"})
     */
    private $reference;

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
    public function setRelocationReason(string $relocationReason): void
    {
        $this->relocationReason = $relocationReason;
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

    /**
     * @return \DateTime
     */
    public function getRentingSince()
    {
        return $this->rentingSince;
    }

    /**
     * @param \DateTime $rentingSince
     */
    public function setRentingSince(\DateTime $rentingSince): void
    {
        $this->rentingSince = $rentingSince;
    }

    /**
     * @return string
     */
    public function getNoticeBy()
    {
        return $this->noticeBy;
    }

    /**
     * @param string $noticeBy
     */
    public function setNoticeBy(string $noticeBy): void
    {
        $this->noticeBy = $noticeBy;
    }
}
