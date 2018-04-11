<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Conversation;
use AppBundle\Entity\ConversationReply;
use AppBundle\Form\ConversationReplyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Conversation controller.
 *
 * @Route("/conversation")
 */
class ConversationController extends Controller
{
    /**
     * Finds and displays a conversation entity.
     *
     * @Route("/show/{conversation}", name="admin.conversation.show")
     *
     * @param Conversation $conversation
     * @param Request $request
     *
     * @ParamConverter("conversation", class="AppBundle:Conversation")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Conversation $conversation, Request $request)
    {
        $deleteForm = $this->createDeleteForm($conversation);

        $form = $this->createForm(ConversationReplyType::class, new ConversationReply());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ConversationReply $conversationReply */
            $conversationReply = $form->getData();
            $conversationReply->setAuthor($this->getUser()->getEmail());
            $conversationReply->setConversation($conversation);

            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($conversationReply);
                $em->flush();
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
            }
            try {
                $this->get('app.service.email_notification')
                    ->sendEmail($conversation->getEmail(), $conversationReply->getReply());
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')
                    ->trans('Unexpected error occurred. Mail not send')
                );
            }

            return $this->redirectToRoute('admin.conversation.show', [
                'conversation' => $conversation->getId()
            ]);
        }

        return $this->render('backend/conversation/show.html.twig', [
            'conversation' => $conversation,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Lists all conversations.
     *
     * @Route("/", name="admin.conversation.index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conversations = $em->getRepository(Conversation::class)->findAll();

        //$this->get('app.service.email_notification')->sendEmail('adswweq');

        return $this->render('backend/conversation/index.html.twig', ['conversations' => $conversations]);
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/delete/{conversation}", name="admin.conversation.delete")
     *
     * @param Request $request
     * @param Conversation $conversation
     *
     * @ParamConverter("conversation", class="AppBundle:Conversation")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Conversation $conversation)
    {
        $form = $this->createDeleteForm($conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($conversation);
                $em->flush();
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
            }
        }

        return $this->redirectToRoute('admin.conversation.index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Conversation $conversation
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Conversation $conversation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.conversation.delete', [
                'conversation' => $conversation->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
