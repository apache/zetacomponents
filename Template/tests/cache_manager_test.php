<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcTemplateCacheManagerTest extends ezcTestCase
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
        $tables = array( 'user', 'cache_templates', 'cache_values' );

        // Get the DB instance
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'No database handler defined' );
        }
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';

        // Setup the template engine
        $config = ezcTemplateConfiguration::getInstance();
        $this->tempDir = $config->compilePath =  $this->createTempDir( "ezcTemplate_" );
        $config->templatePath = $this->basePath . 'templates/';
        $config->disableCache = false;

        $config->cacheManager = new DbCacheManager();

        // Create tables.
        foreach ( $tables as $table )
        {
            try
            {
                $db->exec( "DROP TABLE $table" );
            }
            catch ( Exception $e )
            {
            } // eat
        }

        $schema = ezcDbSchema::createFromFile( 'xml', dirname( __FILE__ ) . '/cache-manager-schema.xml' );
        $schema->writeToDb( $db );

        // insert some data
        $iq = $db->createInsertQuery();
        $s = $iq->insertInto( $db->quoteIdentifier( 'user' ) )
           ->set( $db->quoteIdentifier( 'id' ), 1 )
           ->set( $db->quoteIdentifier( 'name' ), $iq->bindValue( 'Raymond' ) )
           ->set( $db->quoteIdentifier( 'nickname' ), $iq->bindValue( 'sunRay' ) )
           ->prepare();
        $s->execute();
       
        $iq = $db->createInsertQuery();
        $s = $iq->insertInto( $db->quoteIdentifier( 'user' ) )
           ->set( $db->quoteIdentifier( 'id' ), 2 )
           ->set( $db->quoteIdentifier( 'name' ), $iq->bindValue( 'Derick' ) )
           ->set( $db->quoteIdentifier( 'nickname' ), $iq->bindValue( 'Tiger' ) )
           ->prepare();
        $s->execute();
       
        $iq = $db->createInsertQuery();
        $s = $iq->insertInto( $db->quoteIdentifier( 'user' ) )
           ->set( $db->quoteIdentifier( 'id' ), 3 )
           ->set( $db->quoteIdentifier( 'name' ), $iq->bindValue( 'Jan' ) )
           ->set( $db->quoteIdentifier( 'nickname' ), $iq->bindValue( 'Amos' ) )
           ->prepare();
        $s->execute();
    }

    protected function tearDown()
    {
        // Remove tables.
        $db = ezcDbInstance::get(); 
//        $db->exec( 'DROP TABLE cache_templates' );
//        $db->exec( 'DROP TABLE cache_values' );
//        $db->exec( 'DROP TABLE user' );
        $this->removeTempDir();
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

    // Test if the read() call is send to all the cache files.
    public function testMultiCache()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $r = $t->process("cached_page_includes_show_users.ezt");
        $this->assertEquals( "\nCached:\n\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        $db = ezcDbInstance::get(); 
        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );

        $r = $t->process("cached_page_includes_show_users.ezt");
        $this->assertEquals( "\nCached:\n\n\n\n\n1 Raymond bla\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
    }
 

    public function testCleanExpired()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $r = $t->process("cached_page_includes_show_users.ezt");
        $this->assertEquals( "\nCached:\n\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        $db = ezcDbInstance::get(); 
        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );


        // Clean up.
        ezcTemplateConfiguration::getInstance()->cacheManager->cleanExpired();

        // Set the values to the old stuff, without notifying the cache manager.
        $db->exec( 'UPDATE user SET nickname="sunRay" WHERE id=1' );

        // This should show the old template again.
        $r = $t->process("cached_page_includes_show_users.ezt");
        $this->assertEquals( "\nCached:\n\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
    }
 
    public function testCacheBlock()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $r = $t->process("show_users_cache_block.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Update a single user. 
        $db = ezcDbInstance::get(); 
        $db->exec( 'UPDATE user SET nickname="bla" WHERE id=1' );

        // Still cached.
        $r =  $t->process("show_users_cache_block.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond sunRay\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );

        // Send a update signal to the configuration manager.
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );

        $r = $t->process("show_users_cache_block.ezt");
        $this->assertEquals( "\n\n\n\n1 Raymond bla\n\n2 Derick Tiger\n\n3 Jan Amos\n", $r );
    }
/*
    public function testCacheKeys()
    {
        $t = new ezcTemplate();
        $t->configuration->addExtension("Fetch");

        $t->send->id = 1;
        $t->send->name = "aaa";
        $r = $t->process("cache_manager_with_keys.tpl");
        ezcTemplateConfiguration::getInstance()->cacheManager->register("user", 1 );

        $this->assertEquals( "\n\n\n1\naaa\n", $r );

        // Update a single user. 
        $t->send->id = 1;
        $t->send->name = "bla";

        // Still cached.
        $r = $t->process("cache_manager_with_keys.tpl");
        $this->assertEquals( "\n\n\n1\naaa\n", $r );

        // Send a update signal to the configuration manager.
        ezcTemplateConfiguration::getInstance()->cacheManager->update("user", 1 );

        $r = $t->process("cache_manager_with_keys.tpl");
        $this->assertEquals( "\n\n\n1\nbla\n", $r );
    }
*/
}

?>
