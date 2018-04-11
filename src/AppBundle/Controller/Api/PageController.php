<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Page;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\Route;

class PageController extends FOSRestController
{
    /**
     * Get all pages (or only homepage).
     *
     * @Rest\Get("/page")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns all pages (or only homepage).",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="slug", type="string"),
     *             @SWG\Property(property="homepage", type="boolean"),
     *             @SWG\Property(property="in_menu", type="boolean"),
     *             @SWG\Property(property="title", type="string"),
     *             @SWG\Property(property="meta_title", type="string"),
     *             @SWG\Property(property="meta_description", type="string"),
     *             @SWG\Property(property="meta_keywords", type="string"),
     *             @SWG\Property(property="created_at", type="date"),
     *             @SWG\Property(property="content", type="string"),
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="conversation not found"
     * )
     * @SWG\Tag(name="Page")
     * @SWG\Parameter(
     *     name="homepage",
     *     in="query",
     *     type="boolean",
     *     description="True - return homepage, false - return all pages."
     * )
     * @param Request $request
     *
     * @return \AppBundle\Entity\Page|\AppBundle\Entity\Page[]|array|View|null|object
     */
    public function getAllAction(Request $request)
    {
        $isHomepage = $request->get('homepage');
        if ($isHomepage) {
            $results = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(['homepage' => true]);
        } else {
            $results = $this->getDoctrine()->getRepository('AppBundle:Page')->findAll();
        }
        if (empty($results)) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $results;
    }

    /**
     * Get page
     *
     * Get pages by slug.
     *
     * @Rest\Get("/page/{slug}")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return page",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="slug", type="string"),
     *             @SWG\Property(property="homepage", type="boolean"),
     *             @SWG\Property(property="in_menu", type="boolean"),
     *             @SWG\Property(property="title", type="string"),
     *             @SWG\Property(property="meta_title", type="string"),
     *             @SWG\Property(property="meta_description", type="string"),
     *             @SWG\Property(property="meta_keywords", type="string"),
     *             @SWG\Property(property="created_at", type="date"),
     *             @SWG\Property(property="content", type="string"),
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="conversation not found"
     * )
     * @SWG\Tag(name="Page")
     *
     * @param string $slug
     *
     * @return \AppBundle\Entity\Page|View|null|object
     */
    public function getPageAction($slug)
    {
        $singleresult = $this->getDoctrine()->getRepository(Page::class)
            ->findOneBy(['slug' => $slug]);

        if (null === $singleresult) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Get pages in main menu.
     *
     * Get pages in main menu.
     *
     * @Rest\Get("/pagemenu")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return page",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="slug", type="string"),
     *             @SWG\Property(property="homepage", type="boolean"),
     *             @SWG\Property(property="in_menu", type="boolean"),
     *             @SWG\Property(property="title", type="string"),
     *             @SWG\Property(property="meta_title", type="string"),
     *             @SWG\Property(property="meta_description", type="string"),
     *             @SWG\Property(property="meta_keywords", type="string"),
     *             @SWG\Property(property="created_at", type="date"),
     *             @SWG\Property(property="content", type="string"),
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="conversation not found"
     * )
     * @SWG\Tag(name="Page")
     *
     * @return Page[]|array|View
     */
    public function getAllMenuAction()
    {
        $results = $this->getDoctrine()->getRepository(Page::class)->findBy(['inMenu' => true]);

        if (empty($results)) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $results;
    }
}
