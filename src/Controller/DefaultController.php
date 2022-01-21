<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/notFound", name="notFound")
     * @return Response
     */
    public function notFoundHttpPage()
    {
        return $this->render('default/notfound.html.twig');
    }

    /**
     * @Route("/access_denied", name="access_denied")
     * @return Response
     */
    public function accessDenied() {
        return $this->render('default/accessDenied.html.twig');
    }
}
