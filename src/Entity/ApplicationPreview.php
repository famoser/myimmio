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
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationPreviewRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicationPreview extends BaseEntity
{
    use IdTrait;

    /**
     * @var ApplicationSlot
     * @ORM\ManyToOne(targetEntity="ApplicationSlot", inversedBy="previews")
     */
    private $applicationSlot;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="App\Entity\FrontendUser", inversedBy="applications")
     */
    private $frontendUser;

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
     * @return ApplicationSlot
     */
    public function getApplicationSlot()
    {
        return $this->applicationSlot;
    }

    /**
     * @param ApplicationSlot $applicationSlot
     */
    public function setApplicationSlot(ApplicationSlot $applicationSlot)
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
    public function setFrontendUser(FrontendUser $frontendUser)
    {
        $this->frontendUser = $frontendUser;
    }


}
