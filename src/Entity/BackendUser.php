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
use App\Entity\Traits\UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BackendUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BackendUser extends BaseEntity implements AdvancedUserInterface, EquatableInterface
{
    use IdTrait;
    use UserTrait;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="users")
     */
    private $company;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $canAdministerCompany = false;

    /**
     * @var Building[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Building", mappedBy="administrators")
     * @ORM\JoinTable(name="backend_user_buildings")
     */
    private $buildings;

    public function __construct()
    {
        $this->buildings = new ArrayCollection();
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
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ["ROLE_BACKEND_USER"];
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * Also implementation should consider that $user instance may implement
     * the extended user interface `AdvancedUserInterface`.
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
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return bool
     */
    public function getCanAdministerCompany()
    {
        return $this->canAdministerCompany;
    }

    /**
     * @param bool $canAdministerCompany
     */
    public function setCanAdministerCompany(bool $canAdministerCompany): void
    {
        $this->canAdministerCompany = $canAdministerCompany;
    }

    /**
     * @return Building[]|ArrayCollection
     */
    public function getBuildings()
    {
        return $this->buildings;
    }
}
