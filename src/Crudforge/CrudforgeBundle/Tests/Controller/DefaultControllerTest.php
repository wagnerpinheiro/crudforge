<?php

namespace Crudforge\CrudforgeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * setup test
     */
    protected function setUp()
    {
        $this->markTestIncomplete('Teste funcional para a classe DefaultController criado mas não ativo.');
    }
    
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
