<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DemoType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl("admin_homepage"));
    }
    
    public function indexAdminAction()
    {
        return $this->render("::/Default/index_admin.html.twig");
    }
    
    public function demoAction(Request $peticion) {
        $form = $this->createForm(new DemoType());
        
        return $this->render("::/Default/demo.html.twig", array(
            'form' => $form->createView(),
        ));
    }
}
