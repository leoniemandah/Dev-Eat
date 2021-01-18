<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RestaurantVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW','DELETE'])
            && $subject instanceof \App\Entity\Restaurant;
    }

    protected function voteOnAttribute($attribute, $restaurant, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        
        switch ($attribute) {
            case 'EDIT':
              return $restaurant->getUser()->getId() == $user->getId();
                break;
            case 'DELETE':
                return $restaurant->getUser()->getId() == $user->getId();
              break;    
            case 'VIEW':
                return $restaurant->getUser()->getId() == $user->getId();
                break;
        }

        return false;
    }
}
