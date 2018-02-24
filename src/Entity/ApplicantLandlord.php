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
use App\Entity\Traits\ReferenceTrait;
use App\Entity\Traits\UserTrait;
use App\Helper\DateTimeFormatter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantLandlordRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicantLandlord extends BaseEntity
{
    use IdTrait;

    use ReferenceTrait;

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
     * @return \DateTime
     */
    public function getRentingSince()
    {
        return $this->rentingSince;
    }

    /**
     * @param \DateTime $rentingSince
     */
    public function setRentingSince(\DateTime $rentingSince)
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
    public function setNoticeBy(string $noticeBy)
    {
        $this->noticeBy = $noticeBy;
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
