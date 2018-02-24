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
use App\Entity\Traits\ContactTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\PersonTrait;
use App\Entity\Traits\ThingTrait;
use App\Helper\DateTimeFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantEmployerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicantReference extends BaseEntity
{
    use IdTrait;
    use ThingTrait;
    use PersonTrait;
    use ContactTrait;

    /**
     * @var Applicant
     * @ORM\ManyToOne(targetEntity="App\Entity\Applicant", inversedBy="references")
     */
    private $applicant;

    /**
     * @return Applicant
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * @param Applicant $applicant
     */
    public function setApplicant(Applicant $applicant): void
    {
        $this->applicant = $applicant;
    }
}
