<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Almacenes;
use AppBundle\Form\AlmacenesType;

/**
 * Almacenes controller.
 *
 */
class AlmacenesController extends Controller
{

    /**
     * Lists all Almacenes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Almacenes')->findAll();

        return $this->render('::Admin/Almacenes/index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Almacenes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Almacenes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("success", "El Almacén se creo satisfactoriamente.");
            return $this->redirect($this->generateUrl('admin_almacenes_edit', array('id' => $entity->getId())));
        }

        return $this->render('::/Admin/Almacenes/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Almacenes entity.
     *
     * @param Almacenes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Almacenes $entity)
    {
        $form = $this->createForm(new AlmacenesType(), $entity, array(
            'action' => $this->generateUrl('admin_almacenes_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Almacenes entity.
     *
     */
    public function newAction()
    {
        $entity = new Almacenes();
        $form   = $this->createCreateForm($entity);

        return $this->render('::Admin/Almacenes/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Almacenes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Almacenes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacenes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Almacenes:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Almacenes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Almacenes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacenes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Almacenes/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Almacenes entity.
    *
    * @param Almacenes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Almacenes $entity)
    {
        $form = $this->createForm(new AlmacenesType(), $entity, array(
            'action' => $this->generateUrl('admin_almacenes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Almacenes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Almacenes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacenes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->flush();
            $this->addFlash("success", "El formulario se actualizó satisfactoriamente");
            
            return $this->redirect($this->generateUrl('admin_almacenes_edit', array('id' => $id)));
        }
        $this->addFlash("danger", "Se encontraron errores al procesar el formulario");
        return $this->render('::/Admin/Almacenes/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Almacenes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Almacenes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Almacenes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->addFlash("success", "El almacen se eliminó satisfactoriamente");
        return $this->redirect($this->generateUrl('admin_almacenes'));
    }

    /**
     * Creates a form to delete a Almacenes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_almacenes_delete', array('id' => $id)))
            ->setMethod('DELETE')            
            ->getForm()
        ;
        
    }
    
    
}
