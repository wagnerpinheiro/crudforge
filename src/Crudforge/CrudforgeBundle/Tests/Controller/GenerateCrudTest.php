<?php

namespace Crudforge\CrudforgeBundle\Tests\Controller;

use Crudforge\CrudforgeBundle\CrudforgeCore\GenerateCrud;
use Crudforge\CrudforgeBundle\Entity\Fields;
use Crudforge\CrudforgeBundle\Entity\Document;
use Crudforge\CrudforgeBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class GenerateCrudTest extends WebTestCase{
	
	/**
	* @var
	*/
	private $container;
	private $em;
	/**
	 * @var RequestService
	 */
	private $request;
	
	/**
	 * {@inheritDoc}
	 */
	public function setUp()
	{
		static::$kernel = static::createKernel();
		static::$kernel->boot();
		$this->container = static::$kernel->getContainer();
		$this->em = static::$kernel->getContainer()
		->get('doctrine')->getManager();
	}
	
	
	public function testGenerateCrud(){
		
		$core = $this->container->get('crudforge.core');

		$field1 = new Fields();
		$field1->setName('nome');
		$field1->setType('string');
		$field1->setLength(10);
		$field1->setScale(1);
		
		$field2 = new Fields();
		$field2->setName('idade');
		$field2->setType('integer');
		$field2->setLength(100);
		$field2->setScale(1);
		
		$users = new Users();
		$users->setUsername('steve');
		$users->setPassword('1234');
		$users->setEmail('steve@gmail.com');
		$users->setIsActive(true);
		
		$document = new Document();
		$document->setName('TCC');
		$document->setEntity('SteveTCC');
		$document->setRoute('steve_tcc');
		$document->setUser($users);
		$document->addField($field1);
		$document->addField($field2);
		
// 		$document = $this->em->getRepository('CrudforgeBundle:Document')->findOneByName('Estoque');
// 		$document->setName('Teste');
// 		$document->setRoute('estoque_teste');
// 		$document->setEntity('EstoqueTeste');
		
		$core = $this->container->get('crudforge.core');
		$core->setDocument($document);
		$core->generate();
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		parent::tearDown();
		$this->em->close();
	}
	
}
