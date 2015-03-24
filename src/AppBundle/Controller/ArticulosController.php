<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Articulos;
use AppBundle\Form\ArticulosType;

/**
 * Articulos controller.
 *
 */
class ArticulosController extends Controller
{

    /**
     * Lists all Articulos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Articulos')->findAll();

        return $this->render('AppBundle:Articulos:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Articulos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Articulos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_articulos_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Articulos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Articulos entity.
     *
     * @param Articulos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Articulos $entity)
    {
        $form = $this->createForm(new ArticulosType(), $entity, array(
            'action' => $this->generateUrl('admin_articulos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Articulos entity.
     *
     */
    public function newAction()
    {
        $entity = new Articulos();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Articulos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Articulos entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Articulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Articulos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Articulos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Articulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Articulos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Articulos entity.
    *
    * @param Articulos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Articulos $entity)
    {
        $form = $this->createForm(new ArticulosType(), $entity, array(
            'action' => $this->generateUrl('admin_articulos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Articulos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Articulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_articulos_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Articulos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Articulos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Articulos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Articulos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_articulos'));
    }

    /**
     * Creates a form to delete a Articulos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_articulos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
