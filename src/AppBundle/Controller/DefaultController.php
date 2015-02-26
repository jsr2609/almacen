<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DemoType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }
    
    public function demoAction(Request $peticion) {
        $form = $this->createForm(new DemoType());
        
        return $this->render("::/Default/demo.html.twig", array(
            'form' => $form->createView(),
        ));
    }
}
