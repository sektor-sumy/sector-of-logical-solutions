<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\ConversationReply;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Conversation;

class ConversationReplyController extends FOSRestController
{
    /**
     * @Rest\Post("/reply")
     * @param Request $request
     */
    public function postReplyAction(Request $request)
    {
        
    }
}
