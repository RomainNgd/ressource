<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class ResetPasswordController extends AbstractController
{

    public function __construct(
        private readonly AuthService$authService,
        private readonly MailerService $mailerService,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke():JsonResponse
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
}