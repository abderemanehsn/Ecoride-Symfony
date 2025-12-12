<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TripVoter extends Voter
{   
    public const JOIN = 'POST_JOIN';
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
      
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Trip;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
            case self::DELETE:
                if(in_array('ROLE_USER', $user-> getROles())) 
                {
                    return $subject->getDriver()->getId() === $user->getId();
                }

                if(in_array('ROLE_USER', $user-> getROles())) 
                {
                    return true;
                } 
                break;
            case self::JOIN:
                if(in_array('ROLE_USER', $user-> getROles())) 
                {
                    return true;
                }

                if(in_array('ROLE_USER', $user-> getROles())) 
                {
                    return true;
                } 
        }

        return false;
    }
}
