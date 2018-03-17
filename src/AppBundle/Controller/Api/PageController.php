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
     */
    public function getAllAction()
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Page')->findAll();
        if ($singleresult === null) {
            return new View("page not found", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
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
