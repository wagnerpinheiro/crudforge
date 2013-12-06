<?php

namespace Crudforge\CrudforgeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Crudforge\CrudforgeBundle\Entity\Shares;
use Crudforge\CrudforgeBundle\Form\SharesType;

/**
 * Shares controller.
 *
 * @Route("/shares")
 */
class SharesController extends Controller
{
    /**
     * Lists all Shares entities.
     *
     * @Route("/", name="shares")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrudforgeBundle:Shares')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Shares entity.
     *
     * @Route("/{id}/show", name="shares_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Shares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shares entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Shares entity.
     *
     * @Route("/new", name="shares_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Shares();
        $form   = $this->createForm(new SharesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Shares entity.
     *
     * @Route("/create", name="shares_create")
     * @Method("POST")
     * @Template("CrudforgeBundle:Shares:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Shares();
        $form = $this->createForm(new SharesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shares_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Shares entity.
     *
     * @Route("/{id}/edit", name="shares_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Shares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shares entity.');
        }

        $editForm = $this->createForm(new SharesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Shares entity.
     *
     * @Route("/{id}/update", name="shares_update")
     * @Method("POST")
     * @Template("CrudforgeBundle:Shares:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Shares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shares entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SharesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shares_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Shares entity.
     *
     * @Route("/{id}/delete", name="shares_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrudforgeBundle:Shares')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Shares entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shares'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
