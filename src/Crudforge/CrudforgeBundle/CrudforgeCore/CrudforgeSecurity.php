<?php
namespace Crudforge\CrudforgeBundle\CrudforgeCore;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Crudforge\CrudforgeBundle\CrudforgeCore\Security\AclManager;

/**
 * Proxy Class for Security (user session, authentication, authorization)
 *
 * @author wagner
 */
class CrudforgeSecurity {
    
    private $container;
    /**
     * @todo: atualmente a entidade é gerada no CrudforgeBundle, validar depois de acordo com o namespace do usuario (usaremos um bundle para cada usuario?)
     */
    //protected $bundle_name = 'CrudforgeBundle';
    //private $bundle;
    private $user;
    private $aclManager;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;        
        //$this->bundle = $this->container->get('kernel')->getBundle($this->bundle_name);        
    }
    
    /**
     * Get actual user authenticated
     * @return \Symfony\Component\Security\Core\User\User
     */
    public function getUser(){
        if(!$this->user){
            $this->user = $this->container->get('security.context')->getToken()->getUser();
        }        
        return $this->user;        
    }
    
    /**
     * Get AclManager
     * @return AclManager
     */
    public function getAclManager(){
        if(!$this->aclManager){
            $aclProvider =  $this->container->get('security.acl.provider');
            $securityContext =  $this->container->get('security.context');
            $objectIdentityRetrievalStrategy =  $this->container->get('security.acl.object_identity_retrieval_strategy');
            $this->aclManager = new AclManager($aclProvider,$securityContext,$objectIdentityRetrievalStrategy);
        }
        return $this->aclManager;
    }
    
}
