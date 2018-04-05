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
     * @Rest\Post("/conversation-reply/add-reply")
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        $email = $request->get('email');
        $text = $request->get('text');
        $hash = $request->get('hash');

        $conversation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Conversation::class)
            ->findOneBy([
                'hash'=>$hash
            ]);
        if (!$conversation) {
            return new JsonResponse(['message'=>'conversation not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $conversationReply = new ConversationReply();
        $conversationReply->setAuthor($email);
        $conversationReply->setReply($text);
        $conversationReply->setConversation($conversation);

        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($conversationReply);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('logger')->error($e, ['exception' => $e]);
            $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
        }
        return new JsonResponse([
            'message' => 'success',
            'id' => $conversationReply->getId()
        ]);
    }
}
