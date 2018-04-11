<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Conversation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * Class ConversationController
 */
class ConversationController extends FOSRestController
{
    /**
     * Create conversation.
     *
     * This call add new converastion.
     *
     * @Route("/conversation", methods={"POST"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Items(
     *         @SWG\Property(property="message", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="Email of conversation"
     * )
     * @SWG\Parameter(
     *     name="text",
     *     in="query",
     *     type="string",
     *     description="Text of conversation"
     * )
     * @SWG\Tag(name="Conversation")
     *
     * @param Request $request
     *
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
     * Open conversation of user.
     *
     * This call return conversation on page by hash.
     *
     * @Rest\Get("/conversation/{hash}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the conversation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Conversation::class, groups={"full"}))
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Page not found"
     * )
     * @SWG\Tag(name="Conversation")
     *
     * @param string $hash
     *
     * @return View
     */
    public function getAction($hash)
    {
        $result = $this->getDoctrine()->getRepository(Conversation::class)
            ->findOneBy(['hash' => $hash]);

        if (!$result) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $result->toArray();
    }
}
