<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use AppBundle\Entity\Page;
use AppBundle\Entity\User;

/**
 * Class AddNewPageEvent
 */
class AddNewPageEvent extends Event
{
    /**
     * @var Page
     */
    private $page;

    /**
     * @var User
     */
    private $user;


    /**
     * AddNewPageEvent constructor.
     * @param Page $page
     * @param User $user
     */
    public function __construct($page, $user)
    {
        $this->page = $page;
        $this->user = $user;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "add.new.page";
    }
}
