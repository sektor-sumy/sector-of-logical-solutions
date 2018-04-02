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
     * Lists all page entities.
     *
     * @Route("/", name="admin.conversation.index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conversations = $em->getRepository(Conversation::class)->findAll();

        //$this->get('app.service.email_notification')->sendEmail('adswweq');

        return $this->render('backend/conversation/index.html.twig', array(
            'conversations' => $conversations,
        ));
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/show/{conversation}", name="admin.conversation.show")
     * @param Conversation $conversation
     * @ParamConverter("conversation", class="AppBundle:Conversation")
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
            $this->getDoctrine()->getManager()->persist($conversationReply);
            $this->getDoctrine()->getManager()->flush();


            $conversation = $conversationReply->getConversation();

            $reply = $conversationReply->getReply();

            $this->get('app.service.email_notification')->sendEmail($conversation->getEmail(),$reply);


            return $this->redirectToRoute('admin.conversation.show', array('conversation' => $conversation->getId()));
        }
        return $this->render('backend/conversation/show.html.twig', array(
            'conversation' => $conversation,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/delete/{conversation}", name="admin.conversation.delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Conversation $conversation
     * @ParamConverter("conversation", class="AppBundle:Conversation")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Conversation $conversation)
    {
        $form = $this->createDeleteForm($conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conversation);
            $em->flush();
        }

        return $this->redirectToRoute('admin.conversation.index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Conversation $conversation The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conversation $conversation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.conversation.delete', array('conversation' => $conversation->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
