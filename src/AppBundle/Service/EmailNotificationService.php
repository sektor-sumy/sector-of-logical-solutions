<?php

namespace AppBundle\Service;

class EmailNotificationService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * EmailNotificationService constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($mail,$reply)
    {
        $message = (new \Swift_Message('SoLS'))
            ->setFrom('send@example.com')
            ->setTo($mail)
            ->setBody($reply);

        $this->mailer->send($message);
    }
}
