<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require "db_cache_manager.php";
require "fetch.php";


/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateCacheTest extends ezcTestCase
{
    private $tempDir;
    private $basePath;
    private $templatePath;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';

        $config = ezcTemplateConfiguration::getInstance();
        $this->tempDir = $config->compilePath =  $this->createTempDir( "ezcTemplate_" );
        $config->templatePath = $this->basePath . 'templates/';

        $config->cacheManager = new DbCacheManager();

        // Create tables.
        //

        $db = ezcDbInstance::get();

        try
        {
            $db->exec( 'DROP TABLE user' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $db->exec( "CREATE TABLE user ( id int(10) unsigned NOT NULL auto_increment, 
                    name varchar(50) NOT NULL, 
                    nickname varchar(30) NOT NULL,
                    PRIMARY KEY  (id) )" );

        $db->exec ( "INSERT INTO `user` (`id`, `name`, `nickname`) VALUES 
                    (1, 'Raymond', 'sunRay'),
                    (2, 'Derick', 'Tiger'),
                    (3, 'Jan', 'Amos')" );

    }

    protected function tearDown()
    {
        // Remove tables.
        $db = ezcDbInstance::get(); 
        $db->exec( 'DROP TABLE user' );
    }

    public function testRenewIncludedTemplates()
    {
        $t = new ezcTemplate();
        $t->configuration->templatePath = $this->tempDir;

        copy( $this->basePath."/templates/cache_simple_include.tpl", $this->tempDir . "/cache_simple_include.tpl" );
        copy( $this->basePath."/templates/hello_world.tpl", $this->tempDir . "/hello_world.tpl" );

        $t->send->a = "Bernard";
        $r = $t->process( "cache_simple_include.tpl" );
        $this->assertEquals( "\nBernard\nHello world\n", $r );

        // Old value expected. $a is not a cache key.
        $t->send->a = "Bla";
        $r = $t->process( "cache_simple_include.tpl" );
        $this->assertEquals( "\nBernard\nHello world\n", $r );

        // Simulate someone edits the template
        sleep(1); // Otherwise the mtime is the same.
        file_put_contents( $this->tempDir . "/hello_world.tpl", "Goodbye cruel world!");

        $t->send->a = "Bla";
        $r = $t->process( "cache_simple_include.tpl" );
        $this->assertEquals( "\nBla\nGoodbye cruel world!", $r );
    }

    public function testRenewUserViaTemplateFetch()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $r = $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Update a single user. 
        $db = ezcDbInstance::get(); 
        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );

        // Still cached.
        $r =  $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Send a update signal to the configuration manager.
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );

        $r = $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond bla\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
    }

    public function testSignals()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $r = $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );


        $r = $t->process("show_users.ezt");


//        $r = $t->process("show_users.ezt");
//        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
//
//        // Update a single user. 
//        $db = ezcDbInstance::get(); 
//        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );
//
//        // Still cached.
//        $r =  $t->process("show_users.ezt");
//        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
//
//        // Send a update signal to the configuration manager.
//        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );
//
//        $r = $t->process("show_users.ezt");
//        $this->assertEquals( "\n\n\n\n1 Raymond bla\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
    }
 

    public function testCacheKeys()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $t->send->id = 1;
        $t->send->name = "aaa";
        $r = $t->process("cache_manager_with_keys.tpl");





/*
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Update a single user. 
        $db = ezcDbInstance::get(); 
        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );

        // Still cached.
        $r =  $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Send a update signal to the configuration manager.
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );

        $r = $t->process("show_users.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond bla\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
 */

    }



}


class TestUser
{
    public $firstName;
    public $lastName;
    public $name;
    public $id;

    public function cacheKey()
    {
        return $this->id;
    }

    public function __construct($firstName, $lastName, $id = 1 )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->name = $firstName . " " . $lastName;
        $this->id = $id;
    }
}



?>
