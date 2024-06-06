<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendEmail(string $to, string $subject, string $content)
    {
        $email = (new Email())
            ->from('romain.nigond@gmail.com')
            ->to($to)
            ->subject($subject)
            ->text($content)
            ->html('<p>' . $content . '</p>');

        $this->mailer->send($email);
    }
}