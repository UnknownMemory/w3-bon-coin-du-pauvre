<?php

namespace App\Services;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SendEmailService
{

    /* Pas encore fonctionnelle */

    public function send(string $fromMail, string $fromName, string $to, string $subject, string $template): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($fromMail, $fromName))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig");
    }
}
