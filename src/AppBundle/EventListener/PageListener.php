<?php

namespace AppBundle\EventListener;

use AppBundle\Event\AddNewPageEvent;
use AppBundle\Service\EmailNotificationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use AppBundle\Entity\Page;

/**
 * Class PageListener
 */
class PageListener
{
    private $emailNotificationService;

    /**
     * PageListener constructor.
     * @param EmailNotificationService $emailNotificationService
     */
    public function __construct(EmailNotificationService $emailNotificationService)
    {
        $this->emailNotificationService = $emailNotificationService;
    }

    /**
     * @param AddNewPageEvent $event
     */
    public function addNewPage(AddNewPageEvent $event)
    {
        $page = $event->getPage();

        $this->emailNotificationService->sendAdminPageNotification($page, $event->getUser());
    }
}
