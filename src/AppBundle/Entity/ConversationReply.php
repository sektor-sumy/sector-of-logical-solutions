<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppRepository")
 * @ORM\Table(name="conversation_reply")
 */
class ConversationReply
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="conversationReply")
     * @ORM\JoinColumn(name="conversation_id", referencedColumnName="id")
     */
    protected $conversation;

    /**
     * @ORM\Column(name="author", type="string", nullable=false)
     */
    protected $author;

    /**
     * @ORM\Column(name="created_at", type="date", nullable=false)
     */
    protected $created_at;

    /**
     * @ORM\Column(name="reply", type="text", nullable=false)
     */
    protected $reply;


    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @param mixed $conversation
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * @param mixed $reply
     */
    public function setReply($reply)
    {
        $this->reply = $reply;
    }

}