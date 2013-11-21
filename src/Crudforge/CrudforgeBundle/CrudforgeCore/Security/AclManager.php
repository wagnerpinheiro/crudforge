<?php
namespace Crudforge\CrudforgeBundle\CrudforgeCore\Security;

use Problematic\AclManagerBundle\Domain\AclManager as ProblematicAclManager;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;


/**
 * Description of AclManager
 *
 * @author wagner
 */
class AclManager extends ProblematicAclManager{
    
    /**
     * {@inheritDoc}
     */    
    protected function addPermission($domainObject, $field, $mask, $securityIdentity = null, $type = 'object', $replace_existing = false) {
        if(is_null($securityIdentity)){
            $securityIdentity = $this->getUser();
        }
        $context = $this->doCreatePermissionContext($type, $field, $securityIdentity, $mask);
        $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($domainObject);
        
        //fixes setClassPermission without $domainObject
        if(is_null($oid) && $type=='class'){
            $oid = new ObjectIdentity('class', $domainObject);
        }
        
        $acl = $this->doLoadAcl($oid);
        $this->doApplyPermission($acl, $context, $replace_existing);

        $this->getAclProvider()->updateAcl($acl);

        return $this;
    }
    
    public function isGrantedClass($attributes, $class){
        $object = new ObjectIdentity('class', $class);
        return $this->getSecurityContext()->isGranted($attributes, $object);
    }
    
    public function isGranted($attributes, $object = null) {
        return (parent::isGranted($attributes, $object) || $this->isGrantedClass($attributes, get_class($object)));
    }
    
}
