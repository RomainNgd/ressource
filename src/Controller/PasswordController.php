<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\AuthService;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class PasswordController extends AbstractController
{

    public function __construct(
        private readonly AuthService$authService,
        private readonly MailerService $mailerService,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    #[Route(
        path: '/reset-password',
        name: 'reset_password',
        methods: ['POST'],
    )]
    public function resetPasswordInfo():JsonResponse
    {
        $email = $_POST['email'];
        try {
            $user = $this->authService->getUser($email);
            $user->setResetToken(bin2hex(random_bytes(32 / 2)));
            $this->entityManager->flush();
            $this->mailerService->sendEmail(
                $user->getEmail(),
                'Reinitialisation de mot de passe',
                'Voici le lien de réinitialisation de mot de passe http://82.66.110.4:8000/reset/'.$user->getResetToken(),
            );
            return new JsonResponse(null, 200);
        } catch (UserNotFoundException){
            return new JsonResponse(null, 200);
        }
    }

    #[Route(
        path: '/reset-password/{token}',
        name: 'confirm-token',
        methods: ['POST'],
    )]
    public function resetPassword(
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
        } else {
            return new JsonResponse(null, 400);
        }
    }

}