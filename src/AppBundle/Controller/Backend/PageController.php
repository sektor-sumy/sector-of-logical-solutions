<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Page;
use AppBundle\Event\AddNewPageEvent;
use AppBundle\EventListener\PageListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Page controller.
 *
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * Lists all page entities.
     *
     * @Route("/", name="admin.page.index")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Page::class)->findAll();

        $paginator  = $this->get('knp_paginator');


        //$page = $em[1];
        //$this->get('app.service.email_notification')->sendAdminPageNotificationTest($page, $this->getUser());


        /** @var $pagination */
        $pagination = $paginator->paginate(
            $em, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*limit per page*/
        );

        return $this->render('backend/page/index.html.twig', [
            'pages' => $em,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new page entity.
     *
     * @Route("/new", name="admin.page.new")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('AppBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page = $form->getData();

            $em = $this->get('doctrine.orm.entity_manager');
            try {
                $em->persist($page);
                $page->mergeNewTranslations();

                $em->flush();

                $addNewPageEvent = new AddNewPageEvent($page, $this->getUser());
                $this->get('event_dispatcher')->dispatch($addNewPageEvent->getName(), $addNewPageEvent);
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
            }

            return $this->redirectToRoute('admin.page.show', ['page' => $page->getId()]);
        }

        return $this->render('backend/page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/show/{page}", name="admin.page.show")
     *
     * @param Page $page
     *
     * @ParamConverter("page", class="AppBundle:Page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('backend/page/show.html.twig', [
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing page entity.
     *
     * @Route("/edit/{page}", name="admin.page.edit")
     *
     * @param Request $request
     * @param Page $page
     *
     * @ParamConverter("page", class="AppBundle:Page")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('AppBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
            }

            return $this->redirectToRoute('admin.page.edit', [
                'page' => $page->getId(),
            ]);
        }

        return $this->render('backend/page/edit.html.twig', [
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * choise home page
     *
     * @Route("/homepage", name="admin.page.homepage")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function homepageAction(Request $request)
    {
        $pageId = $request->get('id', null);
        $em = $this->getDoctrine()->getManager();

        $homepage = $em->getRepository('AppBundle:Page')->findOneBy(['homepage' => true]);
        if ($homepage) {
            $homepage->setHomepage(false);
        }

        $page = $em->getRepository('AppBundle:Page')->find($pageId);
        if (!$page) {
            return new JsonResponse(['message' => 'Not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $page->setHomepage(true);

        try {
            $em->flush();
        } catch (\Exception $e) {
            $this->get('logger')->error($e, ['exception' => $e]);
            $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
        }

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * choise page in menu
     *
     * @Route("/inmenu", name="admin.page.inmenu")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function inMenuAction(Request $request)
    {
        $pageId = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('AppBundle:Page')->find($pageId);
        $page->setInMenu(!$page->getInMenu());

        try {
            $em->flush();
        } catch (\Exception $e) {
            $this->get('logger')->error($e, ['exception' => $e]);
            $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
        }

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/delete/{page}", name="admin.page.delete")
     *
     * @param Request $request
     * @param Page $page
     *
     * @ParamConverter("page", class="AppBundle:Page")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($page);
                $em->flush();
            } catch (\Exception $e) {
                $this->get('logger')->error($e, ['exception' => $e]);
                $this->addFlash('error', $this->get('translator')->trans('Unexpected error occurred.'));
            }
        }

        return $this->redirectToRoute('admin.page.index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Page $page The page entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.page.delete', [
                'page' => $page->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
