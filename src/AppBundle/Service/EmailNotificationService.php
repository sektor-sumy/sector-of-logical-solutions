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

    public function sendEmail($name)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('vasyavakulo765@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        $this->mailer->send($message);
    }

}