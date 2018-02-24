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
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantEmployerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicantEmployer extends BaseEntity
{
    use IdTrait;

    use ReferenceTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $profession;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salary;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $workingSince;

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
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param int $salary
     */
    public function setSalary(int $salary)
    {
        $this->salary = $salary;
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
}
