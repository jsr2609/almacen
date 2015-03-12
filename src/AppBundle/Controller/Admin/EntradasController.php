<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Entradas;
use AppBundle\Form\EntradasType;
use AppBundle\Event\EntradasEvent;
use AppBundle\EntradasEvents;

/**
 * Entradas controller.
 *
 */
class EntradasController extends Controller
{

    /**
     * Lists all Entradas entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Entradas')->findAll();

        return $this->render('::/Admin/Entradas/index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Entradas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Entradas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Ejecutando eventos entradas.submitted
            $entradasEvent = new EntradasEvent($entity);
            $entradasEvent = $this->container->get('event_dispatcher')->dispatch(EntradasEvents::SUBMITTED, $entradasEvent);
            
            if ($entradasEvent->isPropagationStopped()) {
                $this->addCommentToFlashBag('smtc_error', 'No se ha podido crear el comentario', $comment);
            }
            die("Antes del persist");
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_entradas_show', array('id' => $entity->getId())));
        }
        
        

        return $this->render('::/Admin/Entradas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Entradas entity.
     *
     * @param Entradas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entradas $entity)
    {
        $form = $this->createForm(new EntradasType(), $entity, array(
            'action' => $this->generateUrl('admin_entradas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Continuar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'circle-arrow-right',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Entradas entity.
     *
     */
    public function newAction()
    {
        $entity = new Entradas();
        $form   = $this->createCreateForm($entity);

        return $this->render('::/Admin/Entradas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entradas entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Entradas/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entradas entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Entradas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Entradas entity.
    *
    * @param Entradas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entradas $entity)
    {
        $form = $this->createForm(new EntradasType(), $entity, array(
            'action' => $this->generateUrl('admin_entradas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entradas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_entradas_edit', array('id' => $id)));
        }

        return $this->render('::/Admin/Entradas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Entradas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Entradas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entradas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_entradas'));
    }

    /**
     * Creates a form to delete a Entradas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entradas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function addFlash($type, $message) {
        $this->getRequest()->getSession()->getFlashBag()->add(
            $type,
            $message
        );
    }
}
