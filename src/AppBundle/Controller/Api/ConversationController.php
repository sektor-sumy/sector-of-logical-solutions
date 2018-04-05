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

class ConversationController extends FOSRestController
{
    /**
     * @Rest\Post("/conversation")
     * @param Request $request
     * @return JsonResponse
     */
    public function postCreatedAction(Request $request)
    {
        $email = $request->get('email');
        $text = $request->get('text');

        $conversation = new Conversation();
        $conversation->setEmail($email);
        $conversation->setText($text);

        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($conversation);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('logger')->error($e, ['exception' => $e]);
            $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
        }
        return new JsonResponse(['message' => 'success']);
    }

    /**
     * @Rest\Get("/conversation/{hash}")
     * @param string $hash
     * @return View
     */
    public function getAction($hash)
    {
        $result = $this->getDoctrine()->getRepository(Conversation::class)->findOneBy([
            'hash' => $hash,
            ]);
        if (!$result) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }
        return $result->toArray();
    }
}
