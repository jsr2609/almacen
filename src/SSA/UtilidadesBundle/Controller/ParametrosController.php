<?php

namespace SSA\UtilidadesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SSA\UtilidadesBundle\Entity\Parametros;
use SSA\UtilidadesBundle\Form\ParametrosType;

/**
 * Parametros controller.
 *
 */
class ParametrosController extends Controller
{

    /**
     * Lists all Parametros entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $valor = $em->getRepository('SSAUtilidadesBundle:Parametros')->recuperarValorPorNombre('parametro_prueb');
        
        $entities = $em->getRepository('SSAUtilidadesBundle:Parametros')->findAll();

        return $this->render('SSAUtilidadesBundle:Parametros:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Parametros entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Parametros();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlashMessage("success", "El parámetro se creo satisfactoriamente.");
            return $this->redirect($this->generateUrl('utilidades_parametros_edit', array('id' => $entity->getId())));
        }

        return $this->render('SSAUtilidadesBundle:Parametros:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Parametros entity.
     *
     * @param Parametros $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Parametros $entity)
    {
        $form = $this->createForm(new ParametrosType(), $entity, array(
            'action' => $this->generateUrl('utilidades_parametros_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'floppy-disk'
        )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Parametros entity.
     *
     */
    public function newAction()
    {
        $entity = new Parametros();
        $form   = $this->createCreateForm($entity);

        return $this->render('SSAUtilidadesBundle:Parametros:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Parametros entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSAUtilidadesBundle:Parametros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parametros entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSAUtilidadesBundle:Parametros:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Parametros entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSAUtilidadesBundle:Parametros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parametros entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSAUtilidadesBundle:Parametros:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Parametros entity.
    *
    * @param Parametros $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Parametros $entity)
    {
        $form = $this->createForm(new ParametrosType(), $entity, array(
            'action' => $this->generateUrl('utilidades_parametros_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'floppy-disk'
        ));

        return $form;
    }
    /**
     * Edits an existing Parametros entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSAUtilidadesBundle:Parametros')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parametros entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlashMessage("success", "El parámetro se actualizó satisfactoriamente.");
            return $this->redirect($this->generateUrl('utilidades_parametros_edit', array('id' => $id)));
        }

        return $this->render('SSAUtilidadesBundle:Parametros:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Parametros entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSAUtilidadesBundle:Parametros')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Parametros entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('utilidades_parametros'));
    }

    /**
     * Creates a form to delete a Parametros entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilidades_parametros_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Eliminar',
                'attr' => array('class' => 'btn-danger'),
                'icon' => 'trash'
            ))
            ->getForm()
        ;
    }
    
    public function addFlashMessage($type, $message)
    {
        $this->get('ssa_utilidades.base')->addFlashMessage($type, $message);
    }
}
