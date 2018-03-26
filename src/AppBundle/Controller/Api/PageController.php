<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Page;


class PageController extends FOSRestController
{
    /**
     * @Rest\Get("/page")
     * @param Request $request
     */
    public function getAllAction(Request $request)
    {
        $isHomepage = $request->get('homepage',false);
        if ($isHomepage) {
            $results = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(['homepage'=>true]);

        } else {
            $results = $this->getDoctrine()->getRepository('AppBundle:Page')->findAll();
        }
        if (empty($results)) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $results;
    }

    /**
     * @Rest\Get("/page/{slug}")
     * @param string $slug
     */
    public function getPageAction($slug)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy([
            'slug' => $slug
        ]);
        if ($singleresult === null) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }
}
