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
        $bundle = $this->container->get('kernel')->getBundle('CrudforgeBundle');

        $entity = $this->document->getName();
        $format = "annotation";
        $fields = array();
        foreach($this->document->getFields() as $field){
            $fields[$field->getName()] = array('fieldName' => $field->getName(), 'type' => $field->getType(), 'length' => $field->getLength());
        }
        $with_repository = false;


        $generator->generate($bundle, $entity, $format, array_values($fields), $with_repository);

        //atualiza tabela
        $em = $this->container->get('doctrine')->getManager();
        $schemaTool = new SchemaTool($em);
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($metadatas);

        //gera crud
    }

    /**
     * @todo: #11 implementar atualização do CRUD
     */
    protected function updateCrud(){

    }
}

?>
