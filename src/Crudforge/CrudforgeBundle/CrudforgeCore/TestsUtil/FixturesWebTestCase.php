<?php
namespace Crudforge\CrudforgeBundle\CrudforgeCore\TestsUtil;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

class FixturesWebTestCase extends WebTestCase
{
    /** @var Application **/
    protected static $application;
    
    /**
    * @var
    */
    protected $container;
    
    /** @var \Doctrine\ORM\EntityManager **/
    protected $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
             ->get('doctrine')->getManager();
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load --purge-with-truncate');
    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
    
    /**
    * {@inheritDoc}
    */
    protected function tearDown(){
        parent::tearDown();
        /**
         * @todo esse metodo esta dando erro no teste, verificar porque 
         */
        //$this->em->close();
    }
}