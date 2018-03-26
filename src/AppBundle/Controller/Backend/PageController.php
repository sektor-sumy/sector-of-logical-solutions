<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('AppBundle:Page')->findAll();

        return $this->render('backend/page/index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Creates a new page entity.
     *
     * @Route("/new", name="admin.page.new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('AppBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('admin.page.show', array('id' => $page->getId()));
        }

        return $this->render('backend/page/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/show/{page}", name="admin.page.show")
     * @Method("GET")
     * @param Page $page
     * @ParamConverter("page", class="AppBundle:Page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('backend/page/show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing page entity.
     *
     * @Route("/edit/{page}", name="admin.page.edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Page $page
     * @ParamConverter("page", class="AppBundle:Page")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('AppBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.page.edit', array('id' => $page->getId()));
        }

        return $this->render('backend/page/edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * choise home page
     *
     * @Route("/homepage", name="admin.page.homepage")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function homepageAction(Request $request)
    {
        $pageId = $request->get('id');
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
        $em->flush();

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/delete/{page}", name="admin.page.delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Page $page
     * @ParamConverter("page", class="AppBundle:Page")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('admin.page.index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Page $page The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.page.delete', array('page' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
