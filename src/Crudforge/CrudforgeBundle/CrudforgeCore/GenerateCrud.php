<?php
namespace Crudforge\CrudforgeBundle\CrudforgeCore;
use Crudforge\CrudforgeBundle\Entity\Document;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineEntityGenerator;
//use Symfony\Component\Filesystem\Filesystem;
//use Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand;
use Doctrine\ORM\Tools\SchemaTool;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;


/**
 * Description of GenerateCrud
 *
 * @author wagner
 */
class GenerateCrud {

    protected $document;

    public function __construct(){
       
    }
    
    public function setDocument(Document $document){
         $this->document = $document;        
    }

    public function execute(){
        $this->generateCrud();
    }

        /**
     * @todo: #11 implementar geração do CRUD
     * ver: vendor/sensio/generator-bundle/Sensio/Bundle/GeneratorBundle/Command/GenerateDoctrineEntityCommand.php
     */
    protected function generateCrud(){
        //gera entidade

        $generator =  new DoctrineEntityGenerator($this->getContainer()->get('filesystem'), $this->getContainer()->get('doctrine'));
        /**
         * @todo: atualmente a entidade é gerada no CrudforgeBundle, validar depois de acordo com o namespace do usuario (usaremos um bundle para cada usuario?)
         */
        $bundle = $this->getContainer()->get('kernel')->getBundle('CrudforgeBundle');
        $entity = $this->getName();
        $format = "annotation";
        $fields = array();
        foreach($this->getFields() as $field){
            $fields[$field->name] = array('fieldName' => $field->name, 'type' => $field->type, 'length' => $field->length);
        }
        $with_repository = false;

        $generator->generate($bundle, $entity, $format, array_values($fields), $with_repository);

        //atualiza tabela


        //gera crud
    }

    /**
     * @todo: #11 implementar atualização do CRUD
     */
    protected function updateCrud(){

    }
}

?>
