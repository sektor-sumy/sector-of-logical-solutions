<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 * @ORM\Table(name="page")
 */
class Conversation
{
    protected $email;

    protected $date;

    protected $text;
}