<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait ReferenceTrait
{

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $contactName;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(type="text", nullable=true)
     */
    private $email;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param string $contactName
     */
    public function setContactName(string $contactName)
    {
        $this->contactName = $contactName;
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
    
}
