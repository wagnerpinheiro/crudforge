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

/**
 * @todo srá usado para gerar banco de dados quando não existir
 */
//use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;


/**
 * Description of GenerateCrud
 *
 * @author wagner
 */
class GenerateCrud {

    protected $document;
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function setDocument(Document $document){
         $this->document = $document;
    }

    public function generate(){
        $this->generateCrud();
    }

    /**
     * @todo: #11 implementar geração do CRUD
     * ver: vendor/sensio/generator-bundle/Sensio/Bundle/GeneratorBundle/Command/GenerateDoctrineEntityCommand.php
     */
    protected function generateCrud(){
        //gera entidade

        /* verifica se arquivo existe */
        $generator =  new DoctrineEntityGenerator($this->container->get('filesystem'), $this->container->get('doctrine'));
        /**
         * @todo: atualmente a entidade é gerada no CrudforgeBundle, validar depois de acordo com o namespace do usuario (usaremos um bundle para cada usuario?)
         */
        $bundle_name = 'CrudforgeBundle';
        $bundle = $this->container->get('kernel')->getBundle($bundle_name);

        $entity = $this->document->getName();
        $format = "annotation";
        $fields = array();
        foreach($this->document->getFields() as $field){
            $fields[$field->getName()] = array('fieldName' => $field->getName(), 'type' => $field->getType(), 'length' => $field->getLength(), 'scale' => $field->getScale());
        }
        $with_repository = false;

        /**
         * @todo: replace entitity if exists
         * see: EntityGenerator->setRegenerateEntityIfExists()
         * função: set
         */
        $generator->generate($bundle, $entity, $format, array_values($fields), $with_repository);

        //atualiza tabela
        $em = $this->container->get('doctrine')->getManager();
        $schemaTool = new SchemaTool($em);
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($metadatas);

        //gera crud

        $withWrite = true;
        $prefix = 'user/' . $this->document->getUser()->getId() . '/' . $this->getRoutePrefix($entity);
        $entityClass = $this->container->get('doctrine')->getEntityNamespace($bundle_name).'\\'.$entity;
        $factory = new MetadataFactory($this->container->get('doctrine'));
        $metadata = $factory->getClassMetadata($entityClass)->getMetadata();

        $generator = new DoctrineCrudGenerator($this->container->get('filesystem'), realpath( __DIR__.'/../Resources/skeleton/crud'));
        $generator->generate($bundle, $entity, $metadata[0], $format, $prefix, $withWrite);

        $formGenerator = new DoctrineFormGenerator($this->container->get('filesystem'), realpath( __DIR__.'/../Resources/skeleton/form'));
        $formGenerator->generate($bundle, $entity, $metadata[0]);

        //$this->getContainer()->get('filesystem')->mkdir($bundle->getPath().'/Resources/config/');
        $routing = new RoutingManipulator($bundle->getPath().'/Resources/config/routing.yml');
        try {
            $ret = $routing->addResource($bundle->getName(), $format, '/'.$prefix, 'routing/'.strtolower(str_replace('\\', '_', $entity)));
        } catch (\RuntimeException $exc) {
            $ret = false;
        }

    }

    /**
     * @todo: #11 implementar atualização do CRUD
     */
    protected function updateCrud(){

    }

    protected function getRoutePrefix($entity)
    {
        $prefix = strtolower(str_replace(array('\\', '/'), '_', $entity));

        if ($prefix && '/' === $prefix[0]) {
            $prefix = substr($prefix, 1);
        }

        return $prefix;
    }
}

?>
