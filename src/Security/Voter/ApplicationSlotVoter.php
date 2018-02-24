<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security\Voter;

use App\Entity\Apartment;
use App\Entity\ApplicationSlot;
use App\Entity\BackendUser;
use App\Entity\Building;
use App\Security\Voter\Base\CrudVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ApplicationSlotVoter extends CrudVoter
{
    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::REMOVE], true)) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof ApplicationSlot) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param ApplicationSlot $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof BackendUser) {
            return false;
        }

        //check if admin of building
        if ($user->getBuildings()->contains($subject->getApartment()->getBuilding()))
            return true;

        //check if company admin & from same company
        if ($user->getCanAdministerCompany() && $user->getCompany() != null && $subject->getApartment()->getBuilding()->getCompany() != null)
            return $user->getCompany()->getId() == $subject->getApartment()->getBuilding()->getCompany()->getId();

        return false;
    }
}
