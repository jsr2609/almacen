<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Ejercicios;
use AppBundle\Form\EjerciciosType;

/**
 * Ejercicios controller.
 *
 */
class EjerciciosController extends Controller
{

    /**
     * Lists all Ejercicios entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Ejercicios')->findAll();

        return $this->render('::/Admin/Ejercicios/index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Ejercicios entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Ejercicios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("success", "El Ejercicio se creo satisfactoriamente.");
            return $this->redirect($this->generateUrl('admin_ejercicios_edit', array('id' => $entity->getId())));
        }

        return $this->render('::/Admin/Ejercicios/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Ejercicios entity.
     *
     * @param Ejercicios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ejercicios $entity)
    {
        $form = $this->createForm(new EjerciciosType(), $entity, array(
            'action' => $this->generateUrl('admin_ejercicios_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ejercicios entity.
     *
     */
    public function newAction()
    {
        $entity = new Ejercicios();
        $form   = $this->createCreateForm($entity);

        return $this->render('::/Admin/Ejercicios/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ejercicios entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ejercicios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ejercicios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Ejercicios/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ejercicios entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ejercicios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ejercicios entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Ejercicios/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Ejercicios entity.
    *
    * @param Ejercicios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ejercicios $entity)
    {
        $form = $this->createForm(new EjerciciosType(), $entity, array(
            'action' => $this->generateUrl('admin_ejercicios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ejercicios entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ejercicios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ejercicios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlash("success", "El formulario se actualizó satisfactoriamente");

            return $this->redirect($this->generateUrl('admin_ejercicios_edit', array('id' => $id)));
        }
        $this->addFlash("danger", "Se encontraron errores al procesar el formulario");
        return $this->render('::/Admin/Ejercicios/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Ejercicios entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Ejercicios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ejercicios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->addFlash("success", "El ejercicio se eliminó satisfactoriamente");
        return $this->redirect($this->generateUrl('admin_ejercicios'));
    }

    /**
     * Creates a form to delete a Ejercicios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ejercicios_delete', array('id' => $id)))
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
