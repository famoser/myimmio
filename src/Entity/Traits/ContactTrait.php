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

trait ContactTrait
{
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
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="text")
     */
    private $email;

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
    public function setTelephone(string $telephone): void
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
    public function setTelephoneMobile(string $telephoneMobile): void
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
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * get non-empty communication lines.
     *
     * @return string[]
     */
    public function getCommunicationLines()
    {
        $res = [];
        if (mb_strlen($this->getTelephone()) > 0) {
            $res[] = $this->getTelephone();
        }
        if (mb_strlen($this->getTelephoneMobile()) > 0) {
            $res[] = $this->getTelephoneMobile();
        }
        if (mb_strlen($this->getEmail()) > 0) {
            $res[] = $this->getEmail();
        }

        return $res;
    }
}
