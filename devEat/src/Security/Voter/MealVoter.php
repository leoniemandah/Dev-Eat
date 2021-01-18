<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MealVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW','DELETE'])
            && $subject instanceof \App\Entity\Meal;
    }

    protected function voteOnAttribute($attribute, $meal, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                return $meal->getRestaurant()->getUser()->getId() == $user->getId();
                break;
            case 'VIEW':
                return $meal->getRestaurant()->getUser()->getId() == $user->getId();
                break;
            case 'DELETE':
                return $meal->getRestaurant()->getUser()->getId() == $user->getId();
            break;
        }

        return false;
    }
}
