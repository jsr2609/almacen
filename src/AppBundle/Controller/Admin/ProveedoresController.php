<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Proveedores;
use AppBundle\Form\ProveedoresType;

/**
 * Proveedores controller.
 *
 */
class ProveedoresController extends Controller
{

    /**
     * Lists all Proveedores entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Proveedores')->findAll();

        return $this->render('AppBundle:Proveedores:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Proveedores entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Proveedores();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_proveedores_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Proveedores:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Proveedores entity.
     *
     * @param Proveedores $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Proveedores $entity)
    {
        $form = $this->createForm(new ProveedoresType(), $entity, array(
            'action' => $this->generateUrl('admin_proveedores_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Proveedores entity.
     *
     */
    public function newAction()
    {
        $entity = new Proveedores();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Proveedores:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proveedores entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Proveedores')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedores entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Proveedores:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proveedores entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Proveedores')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedores entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Proveedores:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Proveedores entity.
    *
    * @param Proveedores $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Proveedores $entity)
    {
        $form = $this->createForm(new ProveedoresType(), $entity, array(
            'action' => $this->generateUrl('admin_proveedores_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Proveedores entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Proveedores')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedores entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_proveedores_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Proveedores:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Proveedores entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Proveedores')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proveedores entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_proveedores'));
    }

    /**
     * Creates a form to delete a Proveedores entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_proveedores_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function popupBuscarAction(Request $request)
    {
        $acciones = $request->query->get('acciones');
        $em = $this->getDoctrine()->getManager();
        $registros = $em->getRepository("AppBundle:Proveedores")->recuperarLista();
        $html = $this->renderView('/Admin/Proveedores/popup_buscar.html.twig', array(
            'acciones' => $acciones,
            'registros' => $registros,
        ));
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }
}
