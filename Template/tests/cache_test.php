<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

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
        $config->compilePath = $this->createTempDir( "ezcTemplate_" );
        $config->templatePath = $this->basePath . 'templates/';
   }

    protected function tearDown()
    {
    }

    public function testCacheDirCreation()
    {
        $config = ezcTemplateConfiguration::getInstance();

        $cacheDir = $config->compilePath . DIRECTORY_SEPARATOR . "cached_templates";

        if (file_exists( $cacheDir ) )
        {
            $this->fail( "Did not expect this directory to exists: " . $cacheDir );
        }

        $t = new ezcTemplate();
        $t->send->user = new TestUser( "Bernard", "Black" );
        $t->process( "cache_dynamic.tpl");

        if (!file_exists( $config->compilePath . DIRECTORY_SEPARATOR . "cached_templates" ) )
        {
            $this->fail( "Expected the directory to exists: " . $cacheDir );
        }
    }


    public function testDynamicBlock()
    {
        $t = new ezcTemplate( );
        $t->send->user = new TestUser( "Bernard", "Black" );

        $out = $t->process( "cache_dynamic.tpl");
        $this->assertEquals( "\n[Bernard Black]\n[Bernard Black]\n", $out );

        // Change the user. The first name is cached. The second name should change.
        $t->send->user = new TestUser( "Guybrush", "Threepwood" );
        $out = $t->process( "cache_dynamic.tpl");
        $this->assertEquals( "\n[Bernard Black]\n[Guybrush Threepwood]\n", $out );
    }


}

class TestUser
{
    public $firstName;
    public $lastName;
    public $name;

    public function __construct($firstName, $lastName )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->name = $firstName . " " . $lastName;
    }
}

?>
