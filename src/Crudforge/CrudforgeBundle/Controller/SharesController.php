<?php

namespace Crudforge\CrudforgeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Crudforge\CrudforgeBundle\Entity\Shares;
use Crudforge\CrudforgeBundle\Form\SharesType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

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
        throw new NotFoundHttpException('Vocẽ não tem permissão para executar esta ação.');
        
        $em = $this->getDoctrine()->getManager();
        
        $security = $this->get('security.context');
        $user = $this->get('crudforge.security')->getUser();
        if($security->isGranted('ROLE_ADMIN')){
            $entities = $em->getRepository('CrudforgeBundle:Shares')->findAll();
        }elseif($security->isGranted('ROLE_USER')){
            $entities = $em->getRepository('CrudforgeBundle:Shares')->findBy(array('user'=>$user->getId()));
        }

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all document shares 
     *
     * @Route("/{document_id}/list", name="shares_list")
     * @Template()
     */
    public function listAction($document_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrudforgeBundle:Shares')->findByDocument($document_id);
        
        $document = $em->getRepository('CrudforgeBundle:Document')->find($document_id);

        return array(
            'entities' => $entities,
            'document' => $document
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
     * @Route("/{document_id}/new", name="shares_new")
     * @Template()
     */
    public function newAction($document_id)
    {
        $entity = new Shares();
        
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('CrudforgeBundle:Document')->find($document_id); 
        
        $form   = $this->createForm(new SharesType($document), $entity);

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
        
        $user = $this->get('crudforge.security')->getUser();
        $entity->setUser($user);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $doc = $entity->getDocument();
            return $this->redirect($this->generateUrl('shares_list', array('document_id' => $doc->getId())));
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
            
            //return $this->redirect($this->generateUrl('shares_edit', array('id' => $id)));
            $doc = $entity->getDocument();
            return $this->redirect($this->generateUrl('shares_list', array('document_id' => $doc->getId())));
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
            
            $doc = $entity->getDocument();

            $em->remove($entity);
            $em->flush();
        }

        //return $this->redirect($this->generateUrl('shares'));
        $doc = $entity->getDocument();
        return $this->redirect($this->generateUrl('shares_list', array('document_id' => $doc->getId())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Accept a share
     *
     * @Route("/{id}/accept", name="shares_accept")
     * @Template()
     */
    public function acceptAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        /** @var Shares */
        $entity = $em->getRepository('CrudforgeBundle:Shares')->find($id);
        
        /** @var Users */
        $user_shared = $em->getRepository('CrudforgeBundle:Users')->findOneByEmail($entity->getEmail());
        
        $doc = $entity->getDocument();
        
        if($user_shared){
            $entity->setUserShared($user_shared);
            $em->persist($entity);
            $em->flush();
            
            $builder = new MaskBuilder();
                       
            if($entity->getViewPerm()){
                $builder->add('view');
            }
            if($entity->getEditPerm()){
                $builder->add('edit');
            }
            if($entity->getCreatePerm()){
                $builder->add('create');
            }
            if($entity->getdeletePerm()){
                $builder->add('delete');
            }
            $mask = $builder->get(); 
            $aclManager = $this->get('crudforge.security')->getAclManager();
            $aclManager->setClassPermission($em->getRepository('CrudforgeBundle:' . $doc->getEntity())->getClassName(), 
                    $mask, 
                    $user_shared);
        }

        return $this->redirect($this->generateUrl('shares_list', array('document_id' => $doc->getId())));
        
    }
}
