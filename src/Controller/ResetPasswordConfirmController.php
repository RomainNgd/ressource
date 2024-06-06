<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordConfirmController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function __invoke(
        string $token
    ):JsonResponse
    {
        $user = $this->userRepository->findOneBy(['resetToken' => $token]);
        if ($user instanceof User) {
            $user->setPlainPassword($_POST['password']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);
            $user->eraseCredentials();
            $this->entityManager->flush();
            return new JsonResponse(null, 200);
        } else {
            return new JsonResponse(null, 400);
        }
    }
}