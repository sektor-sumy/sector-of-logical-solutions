<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\ConversationReply;
use AppBundle\Entity\Conversation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\Route;

class ConversationReplyController extends FOSRestController
{
    /**
     * Add new reply in conversation.
     *
     * @Rest\Post("/conversation-reply/add-reply")
     * @SWG\Response(
     *     response=200,
     *     description="Returns id the reply.",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Conversation::class, groups={"full"}))
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="conversation not found"
     * )
     * @SWG\Tag(name="ConversationReply")
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="Email user"
     * )
     * @SWG\Parameter(
     *     name="text",
     *     in="query",
     *     type="string",
     *     description="Text of reply"
     * )
     * @SWG\Parameter(
     *     name="hash",
     *     in="query",
     *     type="string",
     *     description="Hash of conversation"
     * )
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
