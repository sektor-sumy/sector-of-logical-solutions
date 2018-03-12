<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @Route("/admin/{page}", name="admin.page.dashboard")
     */
    public function pageAction($page)
    {
        // replace this example code with whatever you need
        return $this->render('default/admin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'page' => $page,
        ]);
    }
}
