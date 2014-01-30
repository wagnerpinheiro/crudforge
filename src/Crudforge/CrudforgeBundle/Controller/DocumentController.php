<?php

namespace Crudforge\CrudforgeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Crudforge\CrudforgeBundle\Entity\Document;
use Crudforge\CrudforgeBundle\Form\DocumentType;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $security = $this->get('security.context');
        $user = $this->get('crudforge.security')->getUser();
        if($security->isGranted('ROLE_ADMIN')){
            //$entities = $em->getRepository('CrudforgeBundle:Document')->findAll();
            $entities = array();
        }elseif($security->isGranted('ROLE_USER')){
            $entities = $em->getRepository('CrudforgeBundle:Document')->findBy(array('user'=>$user->getId()));
        }
        return array(
            'entities' => $entities
        );
    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}/show", name="document_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Document();
        $form   = $this->createForm(new DocumentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Document entity.
     *
     * @Route("/create", name="document_create")
     * @Method("POST")
     * @Template("CrudforgeBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Document();
        $form = $this->createForm(new DocumentType(), $entity);
        $form->bind($request);
        
        $user = $this->get('crudforge.security')->getUser();
        $entity->setUser($user);
        $entity->setProperEntity();
        $entity->setProperRoute();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $aclManager = $this->get('crudforge.security')->getAclManager();
            $aclManager->setObjectPermission($entity, MaskBuilder::MASK_OWNER);
            
            //return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('fields_list', array('document_id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createForm(new DocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Document entity.
     *
     * @Route("/{id}/update", name="document_update")
     * @Method("POST")
     * @Template("CrudforgeBundle:Document:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrudforgeBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DocumentType(), $entity);
        $editForm->bind($request);
        
        $entity->setProperEntity();
        $entity->setProperRoute();

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            //adicionado temporariamente para gerar ACL dos schemas já cadastrados no ambiente dev, remover quando em produção
            $aclManager = $this->get('crudforge.security')->getAclManager();
            $aclManager->setObjectPermission($entity, MaskBuilder::MASK_OWNER);
            
                        
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}/delete", name="document_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrudforgeBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('document'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Generate CRUD.
     *
     * @Route("/{id}/generateCrud", name="generate_crud")
     * @Template()
     */
    public function generateCrudAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrudforgeBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }
        /** @var GenerateCrud  */
        $core = $this->get('crudforge.core');
        $core->setDocument($entity);
        $core->generate();
        
        /**
         * @todo Redirect não esta funcionando, provavelmente pq é utilizado uma rota via anotação no controller do crud 
         */
        //return $this->redirect($this->generateUrl($entity->getRoute()));
        //return $this->redirect($this->generateUrl('schemas'));
        
        //workaround
        $response = $this->forward('CrudforgeBundle:' . $entity->getEntity() . ':index');        
        return $response;
        
        //teste de gambiarra 1
        /*
        return $this->redirect($this->generateUrl('doc_schema_action',array(
            'prefix'=>$entity->getRoute(),
            'action'=>'redirect'
            )
        ));
         * 
         */         
        
        //teste de gambiarra 2
        /*
        $response = $this->forward('CrudforgeBundle:Document:getSchema', array(
            'prefix'=>$entity->getRoute(),
            'action'=>'redirect'
        ));        
        return $response;
        */
    }

    /**
     * Get Document menu.
     *
     * @Route("/menu", name="document_menu")
     * @Template("CrudforgeBundle:Document:menu.html.twig")
     */
    public function getMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $security = $this->get('security.context');
        $user = $this->get('security.context')->getToken()->getUser();
        if($security->isGranted('ROLE_ADMIN')){
            //$entities = $em->getRepository('CrudforgeBundle:Document')->findAll();
            $entities = array();
        }elseif($security->isGranted('ROLE_USER')){
            $entities = $em->getRepository('CrudforgeBundle:Document')->findBy(array('user'=>$user->getId()));
        }

        $router = $this->container->get('router');
        $routes = array();
        $i = 0;
        foreach($entities as $e){
            $route_test = $e->getRoute() ;
            if($router->getRouteCollection()->get($route_test)){
                $routes[$i]['name'] = $e->getName();
                $routes[$i++]['route'] = $route_test;
            }            
        }

        return array(            
            'routes' => $routes
        );
    }
    
    /**
     * Get Shared menu.
     *
     * @Route("/shared_menu", name="shared_menu")
     * @Template("CrudforgeBundle:Document:menu.html.twig")
     */
    public function getSharedMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $security = $this->get('security.context');
        $user = $this->get('security.context')->getToken()->getUser();
        if($security->isGranted('ROLE_ADMIN')){
            $shares = array();
        }elseif($security->isGranted('ROLE_USER')){
            $shares = $em->getRepository('CrudforgeBundle:Shares')->findBy(array('user_shared'=>$user->getId()));
        }
               
        
        $router = $this->container->get('router');
        $routes = array();
        $i=0;
        foreach($shares as $s){
            $e = $s->getDocument();
            $route_test = $e->getRoute() ;
            if($router->getRouteCollection()->get($route_test)){
                $routes[$i]['name'] = $e->getUser() . ' : ' . $e->getName();
                $routes[$i++]['route'] = $route_test;
            }            
        }

        return array(
            'routes' => $routes
        );
    }
    
    /**
     * Go to schema
     * @todo Remover essas gambiarras que não estão sendo utilizadas, ver bug do redirect ao gerar o crud
     * @Route("/schema_action/{prefix}/{action}", name="doc_schema_action")
     * @Template()
     */
    public function getSchemaAction($prefix, $action){
        if($action=='edit'){      
            $response = $this->forward('CrudforgeBundle:Fields:list', array(
                'document_id'  => 12
            ));
        }
        
        if($action=='redirect'){
            return $this->redirect($this->generateUrl($prefix));            
        }

        // ... further modify the response or return it directly

        return $response;
    }
}
