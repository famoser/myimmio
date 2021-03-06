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
use App\Entity\Traits\PersonTrait;
use App\Entity\Traits\UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FrontendUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class FrontendUser extends BaseEntity implements AdvancedUserInterface, EquatableInterface
{
    use IdTrait;
    use UserTrait;
    use PersonTrait;
    use AddressTrait;

    /**
     * @var Application[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="frontendUser")
     */
    private $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_FRONTEND_USER'];
    }

    /**
     * check if this is the same user
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!($user instanceof static)) {
            return false;
        }

        return $this->isEqualToUser($user);
    }

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        return $this->getUserIdentifier();
    }

    /**
     * @return Application[]|ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }
}
