<?php

namespace Crudforge\CrudforgeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Crudforge\CrudforgeBundle\Entity\Fields;
use Crudforge\CrudforgeBundle\Form\FieldsType;

/**
 * Fields controller.
 *
 * @Route("/fields")
 */
class FieldsController extends Controller
{
    /**
     * Lists all Fields entities.
     *
     * @Route("/", name="fields")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrudforgeBundle:Fields')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all Fields entities.
     *
     * @Route("/{document_id}/list", name="fields_list")
     * @Template()
     */
    public function listAction($document_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrudforgeBundle:Fields')->findByDocument($document_id);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Fields entity.
     *
     * @Route("/{id}/show", name="fields_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Fields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fields entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Fields entity.
     *
     * @Route("/new", name="fields_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fields();
        $form   = $this->createForm(new FieldsType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Fields entity.
     *
     * @Route("/create", name="fields_create")
     * @Method("POST")
     * @Template("CrudforgeBundle:Fields:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Fields();
        $form = $this->createForm(new FieldsType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $doc = $entity->getDocument();
            return $this->redirect($this->generateUrl('fields_list', array('document_id' => $doc->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Fields entity.
     *
     * @Route("/{id}/edit", name="fields_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Fields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fields entity.');
        }

        $editForm = $this->createForm(new FieldsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fields entity.
     *
     * @Route("/{id}/update", name="fields_update")
     * @Method("POST")
     * @Template("CrudforgeBundle:Fields:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Fields')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fields entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FieldsType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $doc = $entity->getDocument();
            return $this->redirect($this->generateUrl('fields_list', array('document_id' => $doc->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fields entity.
     *
     * @Route("/{id}/delete", name="fields_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrudforgeBundle:Fields')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fields entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fields'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
