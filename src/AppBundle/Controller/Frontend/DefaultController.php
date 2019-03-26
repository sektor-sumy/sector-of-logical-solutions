<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/default/index.html.twig');
    }


    /**
     * @Route("/switchLang", name="switch.lang")
     */
    public function index1Action(Request $request)
    {
        $lang = $request->get('locale');

        $translated = $this->get('translator');
        $translated->setLocale($lang);

        $session = $this->get('session');
        $session->set('_locale', $lang);

        return $this->redirectToRoute('homepage');
    }
}
