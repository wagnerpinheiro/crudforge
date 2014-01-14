<?php

namespace Crudforge\CrudforgeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Crudforge\CrudforgeBundle\CrudforgeCore\CrudforgeSecurity;


class CrudforgeSecurityTest extends WebTestCase{
	
	
	/**
     * setup test
     */
    protected function setUp()
    {
        $this->markTestIncomplete('O teste para a classe de segurança esta incompleto e não funcional');
    }

	public function testCompleteScenario()
	{
		
	// Novo usuário
	$client = static::createClient();
        
    // Usuário tenta acessar uma URL direta, antes de passar pelo login
	$crawler = $client->request('GET', '/document/');
	$this->assertEquals(302, $client->getResponse()->getStatusCode());
	
	// Verifica se o usuario é redirecionado para pagina de login
	$crawler = $client->followRedirect();
	$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
	
}