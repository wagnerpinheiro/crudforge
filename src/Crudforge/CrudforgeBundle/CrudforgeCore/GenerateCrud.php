<?php
namespace Crudforge\CrudforgeBundle\CrudforgeCore;
use Crudforge\CrudforgeBundle\Entity\Document;
use Symfony\Component\DependencyInjection\ContainerInterface;

//from use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineEntityCommand
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineEntityGenerator;

//from use Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand;
//from use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand
use Doctrine\ORM\Tools\SchemaTool;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Doctrine\Bundle\DoctrineBundle\Mapping\MetadataFactory;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;
use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * @todo será usado para gerar banco de dados quando não existir
 */
//use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;


/**
 * Generate Crud Cache Classes from Document
 *
 * @author wagner
 */
class GenerateCrud {

    private $document;
    private $entity_name;
    private $route_prefix;
    private $container;
    /**
     * @todo: atualmente a entidade é gerada no CrudforgeBundle, validar depois de acordo com o namespace do usuario (usaremos um bundle para cada usuario?)
     */
    protected $bundle_name = 'CrudforgeBundle';
    private $bundle;
    
    //entity options
    protected $entity_format = "annotation";
    protected $entity_with_repository = false;
    
    protected $crud_with_write = true;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;        
        $this->bundle = $this->container->get('kernel')->getBundle($this->bundle_name);
    }

    public function setDocument(Document $document){
         $this->document = $document;
         $this->entity_name = $this->document->getEntity(); 
         $this->route_prefix = str_replace('_', '/', $this->document->getRoute());
    }

    public function generate(){
        $this->cleanCrudCache();
        $this->generateEntity();
        $this->setEntityOwner();
        $this->updateSchema();        
        $this->generateCrud();
    }
    
    protected function cleanCrudCache(){
        
        $bundle_root = $this->bundle->getPath();
        $entity = $this->entity_name;
        $files = array(
            "{$bundle_root}/Controller/{$entity}Controller.php",
            "{$bundle_root}/Entity/{$entity}.php",
            "{$bundle_root}/Form/{$entity}Type.php",
            "{$bundle_root}/Tests/Controller/{$entity}ControllerTest.php",
            "{$bundle_root}/Resources/views/{$entity}/edit.html.twig",
            "{$bundle_root}/Resources/views/{$entity}/index.html.twig",
            "{$bundle_root}/Resources/views/{$entity}/new.html.twig",
            "{$bundle_root}/Resources/views/{$entity}/show.html.twig",
        );
            
        foreach($files as $file){
            if(file_exists($file)){
                unlink($file);                
            }
        }

        //{$bundle_root}/Resources/config/routing.yml        
    }
            
    protected function generateEntity(){
        /* verifica se arquivo existe */
        $generator =  new DoctrineEntityGenerator($this->container->get('filesystem'), $this->container->get('doctrine'));
               
        $fields = array();
        foreach($this->document->getFields() as $field){
            $fields[$field->getProperFieldName()] = array(
                'fieldName' => $field->getProperFieldName(), 
                'type' => $field->getType(), 
                'length' => $field->getLength(), 
                'scale' => $field->getScale()
            );
        }

        /**
         * @todo: replace entitity if exists
         * see: EntityGenerator->setRegenerateEntityIfExists()
         * função: set
         */
        $generator->generate($this->bundle, $this->entity_name, $this->entity_format, array_values($fields), $this->entity_with_repository);
        
    }
    
    /**
     * Update database schema from Document Entity
     */
    protected function updateSchema(){
        $em = $this->container->get('doctrine')->getManager();
        $schemaTool = new SchemaTool($em);
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($metadatas);
    }
    
    /**
     * Set class owner in ACL
     * Como não é possivel adicionar um ACL apenas para uma classe sem ter um objeto instaciado (?! ver #41)
     * o ACL é montado diretamente no banco de dados #gambiarra
     */
    protected function setEntityOwner(){
        $security = new CrudforgeSecurity($this->container);
        $aclManager = $security->getAclManager();
        $entityClass = $this->container->get('doctrine')->getEntityNamespace($this->bundle_name).'\\'.$this->entity_name;
        $aclManager->setClassPermission($entityClass, MaskBuilder::MASK_OWNER);        
    }

    /**
     * Generate Crud from Entity
     */   
    protected function generateCrud(){
        
        //$prefix = 'user/' . $this->document->getUser()->getId() . '/' . $this->getRoutePrefix($this->entity_name);
        $prefix = $this->route_prefix;
        $entityClass = $this->container->get('doctrine')->getEntityNamespace($this->bundle_name).'\\'.$this->entity_name;
        $factory = new MetadataFactory($this->container->get('doctrine'));
        $metadata = $factory->getClassMetadata($entityClass)->getMetadata();

        $generator = new DoctrineCrudGenerator($this->container->get('filesystem'), realpath( __DIR__.'/../Resources/skeleton/crud'));
        $generator->generate($this->bundle, $this->entity_name, $metadata[0], $this->entity_format, $prefix, $this->crud_with_write);

        $formGenerator = new DoctrineFormGenerator($this->container->get('filesystem'), realpath( __DIR__.'/../Resources/skeleton/form'));
        $formGenerator->generate($this->bundle, $this->entity_name, $metadata[0]);

        //$this->getContainer()->get('filesystem')->mkdir($bundle->getPath().'/Resources/config/');
        $routing = new RoutingManipulator($this->bundle->getPath().'/Resources/config/routing.yml');
        try {
            $ret = $routing->addResource($this->bundle->getName(), $this->entity_format, '/'.$prefix, 'routing/'. $this->document->getRoute());
        } catch (\RuntimeException $exc) {
            $ret = false;
        }

    }

    protected function getRoutePrefix($entity)
    {
        $prefix = strtolower(str_replace(array('\\', '/'), '_', $entity));

        if ($prefix && '/' === $prefix[0]) {
            $prefix = substr($prefix, 1);
        }

        return $prefix;
    }
    
    public function getDocumentByEntity($entity){
        
        $em = $this->container->get('doctrine')->getManager();
        $document = $em->getRepository('CrudforgeBundle:Document')->findOneBy(array('entity'=>$entity));
        return $document;
        
    }
    
}

?>
