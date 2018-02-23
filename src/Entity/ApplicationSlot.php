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
use App\Entity\Traits\ThingTrait;
use App\Entity\Traits\UserTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     */
    private $startAt;

    /**
     * @var \DateTime
     */
    private $endAt;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $welcomeHeader;

    /**
     * @var string
     */
    private $welcomeText;

    /**
     * @var Apartment
     * @ORM\ManyToOne(targetEntity="Apartment", inversedBy="applicationSlots")
     */
    private $apartment;

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        return $this->name;
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
    public function setStartAt(\DateTime $startAt): void
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
    public function setEndAt(\DateTime $endAt): void
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
    public function setIdentifier(string $identifier): void
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
    public function setApartment(Apartment $apartment): void
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
    public function setWelcomeHeader(string $welcomeHeader): void
    {
        $this->welcomeHeader = $welcomeHeader;
    }

    /**
     * @return string
     */
    public function getWelcomeText(): string
    {
        return $this->welcomeText;
    }

    /**
     * @param string $welcomeText
     */
    public function setWelcomeText(string $welcomeText): void
    {
        $this->welcomeText = $welcomeText;
    }
}
