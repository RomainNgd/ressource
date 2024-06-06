<?php

namespace App\Voter;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        // This voter only works for User objects and the 'edit' attribute
        return $attribute === self::EDIT && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is not logged in, deny access
        if (!$user instanceof User) {
            return false;
        }

        // Check if the user can edit their own profile
        if ($subject instanceof User) {
            return $user->getId() === $subject->getId();
        }

        return false;
    }

}