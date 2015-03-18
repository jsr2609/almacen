<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\EntradaDetalles;
use AppBundle\Form\EntradaDetallesType;

/**
 * EntradaDetalles controller.
 *
 */
class EntradaDetallesController extends Controller
{

    /**
     * Lists all EntradaDetalles entities.
     *
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entrada = $em->getRepository("AppBundle:Entradas")->find($id);

        $entities = $em->getRepository('AppBundle:EntradaDetalles')->findAll();

        return $this->render('/Admin/EntradaDetalles/index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EntradaDetalles entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EntradaDetalles();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_entradadetalles_show', array('id' => $entity->getId())));
        }

        return $this->render('/Admin/EntradaDetalles/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EntradaDetalles entity.
     *
     * @param EntradaDetalles $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EntradaDetalles $entity)
    {
        $form = $this->createForm(new EntradaDetallesType(), $entity, array(
            'action' => $this->generateUrl('admin_entradadetalles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EntradaDetalles entity.
     *
     */
    public function newAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entity = new EntradaDetalles();
            $form   = $this->createCreateForm($entity);

            $html = $this->renderView('/Admin/EntradaDetalles/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => 'Correcto');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
     * Finds and displays a EntradaDetalles entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('/Admin/EntradaDetalles/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EntradaDetalles entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('/Admin/EntradaDetalles/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EntradaDetalles entity.
    *
    * @param EntradaDetalles $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EntradaDetalles $entity)
    {
        $form = $this->createForm(new EntradaDetallesType(), $entity, array(
            'action' => $this->generateUrl('admin_entradadetalles_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EntradaDetalles entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_entradadetalles_edit', array('id' => $id)));
        }

        return $this->render('/Admin/EntradaDetalles/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EntradaDetalles entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_entradadetalles'));
    }

    /**
     * Creates a form to delete a EntradaDetalles entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entradadetalles_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
