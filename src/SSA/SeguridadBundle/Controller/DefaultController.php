<?php

namespace SSA\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SSASeguridadBundle:Default:index.html.twig', array('name' => $name));
    }
}
