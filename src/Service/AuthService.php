<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class AuthService
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Security $security,
    )
    {
    }

    public function getCurrentUser(): User
    {
        $identifier = $this->security->getUser()->getUserIdentifier();
        $user = $this->getUserOrNull($identifier);
        if (!$user){
            throw new UserNotFoundException();
        } else {
            return $user;
        }
    }

    public function getUser(string $identifier): User
    {
        $user = $this->getUserOrNull($identifier);
        if (!$user){
            throw new UserNotFoundException();
        } else {
            return $user;
        }
    }

    private function getUserOrNull(string $identifier): ?User
    {
        return $this->userRepository->findOneBy(['email' => $identifier]);
    }

}