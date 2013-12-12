<?php
namespace Crudforge\CrudforgeBundle\Tests\Controller;
use Crudforge\CrudforgeBundle\CrudforgeCore\TestsUtil\FixturesWebTestCase;

/*
use Crudforge\CrudforgeBundle\CrudforgeCore\GenerateCrud;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
*/

use Crudforge\CrudforgeBundle\Entity\Fields;
use Crudforge\CrudforgeBundle\Entity\Document;
use Crudforge\CrudforgeBundle\Entity\Users;

class GenerateCrudTest extends FixturesWebTestCase{
	
	public function testGenerateCrud(){
	
            $user = $this->em->getRepository('CrudforgeBundle:Users')->findOneByUsername('dummy');
            if(!$user){
                $user = new Users();
                $user->setUsername('dummy');
                $user->setPassword('1234');
                $user->setEmail('dummy@gmail.com');
                $user->setIsActive(true);
                $this->em->persist($user);
                //$this->em->flush();
            }
            
            $document = $this->em->getRepository('CrudforgeBundle:Document')->findOneByName('TCC');
            if(!$document){
                $field1 = new Fields();
                $field1->setName('nome');
                $field1->setType('string');
                $field1->setLength(10);
                $field1->setScale(1);
                $this->em->persist($field1);

                $field2 = new Fields();
                $field2->setName('idade');
                $field2->setType('integer');
                $field2->setLength(100);
                $field2->setScale(1);
                $this->em->persist($field2);

                $document = new Document();
                $document->setUser($user);
                $document->setName('TCC');
                $document->setEntity('SteveTcc');
                $document->setRoute('steve_tcc');            
                $document->addField($field1);
                $document->addField($field2);   
                $this->em->persist($document);
            }
            
            $this->em->flush();

            $core = $this->container->get('crudforge.core');
            $core->setDocument($document);
            $core->generate();
	}
	
	
}
