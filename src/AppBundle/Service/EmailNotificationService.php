<?php

namespace AppBundle\Service;

use AppBundle\Entity\Page;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

class EmailNotificationService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * EmailNotificationService constructor.
     * @var \Symfony\Component\Templating\EngineInterface
     * @param \Swift_Mailer $mailer
     */
    protected $templating;

    public function __construct(\Swift_Mailer $mailer, EntityManager $em, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
    }

    /**
     * @param $mail
     * @param $reply
     */
    public function sendEmail($mail, $reply)
    {
        $message = (new \Swift_Message('SoLS'))
            ->setFrom('send@example.com')
            ->setTo($mail)
            ->setBody($reply);

        $this->mailer->send($message);
    }

    /**
     * @param Page $page
     * @param User $initiator
     */
    public function sendAdminPageNotification(Page $page, User $initiator)
    {
        $users = $this->em->getRepository(User::class)->findByRole(User::ROLE_SUPER_ADMIN);

        foreach ($users as $item) {
            $message = (new \Swift_Message('SoLS'))
                ->setFrom('send@example.com')
                ->setTo($item->getEmail())
                ->setBody(
                    $this->templating->render('email/add.new.page.html.twig', [
                        'page' => $page,
                        'user' => $initiator,
                        'lang' => 'ru',
                    ]),
                    'text/html'
                );
            $this->mailer->send($message);
        }
    }

    /**
     * @param Page $page
     * @param User $initiator
     */
    public function sendAdminPageNotificationTest(Page $page, User $initiator)
    {
        $users = $this->em->getRepository(User::class)->findByRole(User::ROLE_SUPER_ADMIN);

        foreach ($users as $item) {
            $message = (new \Swift_Message('SoLS'))
                ->setFrom('send@example.com')
                ->setTo($item->getEmail())
                ->setBody(
                    $this->templating->render(':email:add.new.page.html.twig', [
                        'page' => $page,
                        'user' => $initiator,
                        'lang' => 'ru',
                    ]),
                    'text/html'
                );
            $this->mailer->send($message);
        }
    }
}
