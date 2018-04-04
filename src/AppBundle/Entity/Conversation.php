<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConversationRepository")
 * @ORM\Table(name="conversation")
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(name="hash", type="string", nullable=false, unique=true)
     */
    protected $hash;
    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * @ORM\Column(name="created_at", type="date", length=255, nullable=false)
     */
    protected $created_at;

    /**
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    protected $text;

    /**
     * ConversationReply [] | ArrayCollection
     * @ORM\OneToMany(targetEntity="ConversationReply", mappedBy="conversation")
     */
    private $conversationReplies;

    public function __construct()
    {
        $this->conversationReplies = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->hash = hash('sha256', uniqid(null, true));
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

    public function getConversationReplies()
    {
        return $this->conversationReplies;
    }

    /**
     * @param $conversationReply
     * @return $this
     */
    public function addConversationReply(ConversationReply $conversationReply)
    {
        $this->conversationReplies->add($conversationReply);

        return $this;
    }

    public function removeConversationReply(ConversationReply $conversationReply)
    {
        $this->conversationReplies->remove($conversationReply);
    }

    public function clearConversationReply()
    {
        foreach ($this->getConversationReplies() as $conversationReply) {
            $this->removeConversationReply($conversationReply);
        }
    }

    public function getConversationRepliesByArray()
    {
        $conversationReplies = [];
        /** @var ConversationReply $conversationReply */
        foreach ($this->getConversationReplies() as $conversationReply) {
            $conversationReplies[$conversationReply->getId()] = [
                'reply' => $conversationReply->getReply(),
                'author' => $conversationReply->getAuthor(),
                'createdAt' => $conversationReply->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }
        return $conversationReplies;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function toArray()
    {
        return [
            'text'=>$this->getText(),
            'email'=>$this->getEmail(),
            'author'=>$this->getAuthor(),
            'hash'=>$this->getHash(),
            'conversationReplies'=> $this->getConversationRepliesByArray(),
        ];
    }
}