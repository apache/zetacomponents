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
        $this->tempDir = $config->compilePath =  $this->createTempDir( "ezcTemplate_" );
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

    ///////////////////////////////////////////////////////////////////////////////////////////
    // Test the dynamic block.
    // Tested in the regression_test:
    // - Variable declaration in the dynamic block.

    // Test whether the dynamic block changes when the {use} variable changes.
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

    // - Test whether the all the dynamic block changes when the {use} variable changes.
    // - Test whether a new variable can be inserted in the dynamic block.
    // - Test whether the new variable can be updated an reused in the second dynamic block.
    // - Test whether the new variable is static. 
    // - Test whether the static new variable can be used for dynamic calculations in the dynamic block.
    public function testDynamicBlockAdvanced()
    {
        $t = new ezcTemplate( );
        $t->send->user = new TestUser( "Bernard", "Black" );
        $out = $t->process( "cache_dynamic_advanced.tpl");

        $this->assertEquals( "\n[2]\n[Bernard Black]\n[Nr 2]\n[Bernard Black]\n[Nr 3]\n[4]\n[Bernard Black]\n", $out );

        $t->send->user = new TestUser( "Guybrush", "Threepwood", 10 );
        $out = $t->process( "cache_dynamic_advanced.tpl");

        $this->assertEquals( "\n[2]\n[Bernard Black]\n[Nr 2]\n[Guybrush Threepwood]\n[Nr 3]\n[13]\n[Guybrush Threepwood]\n", $out );
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    // Test the cache keys.

    public function testCacheKeyNonObject()
    {
        $t = new ezcTemplate();
        $t->send->number = 42;
        $t->send->string = "Hello world";
        $t->send->static = "1";

        $out = $t->process( "cache_key_non_object.tpl");
        $this->assertEquals( "\n[1]\n[42]\n[Hello world]\n", $out );

        $t->send->static = 2; // Static will not change, because it's cached.
        $out = $t->process( "cache_key_non_object.tpl");
        $this->assertEquals( "\n[1]\n[42]\n[Hello world]\n", $out );

        // Change the number only.
        $t->send->number = 5;
        $out = $t->process( "cache_key_non_object.tpl");
        $this->assertEquals( "\n[2]\n[5]\n[Hello world]\n", $out );

        // Change the string.
        $t->send->string = "blarp";
        $out = $t->process( "cache_key_non_object.tpl");
        $this->assertEquals( "\n[2]\n[5]\n[blarp]\n", $out );
    }


    public function testCacheKeyObjectWithKeyMethod()
    {
        // Should call a function, if it's defined.
        $t = new ezcTemplate();
        $t->send->user = new TestUser("Bernard", "Black", 23);

        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Bernard Black]\n", $out );

        // The ID didn't change, so keep the same name.
        $t->send->user = new TestUser("Guybrush", "Threepwood", 23);
        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Bernard Black]\n", $out );

        // The ID DID change, so change the name.
        $t->send->user = new TestUser("Guybrush", "Threepwood", 88);
        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Guybrush Threepwood]\n", $out );
    }

    public function testCacheKeyObjectWithoutKeyMethod()
    {
        // Should call a function, if it's defined.
        $t = new ezcTemplate();
        $t->send->user = new TestUser("Bernard", "Black", 23);
      
        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Bernard Black]\n", $out );

        // The ID didn't change, so keep the same name.
        $t->send->user = new TestUser("Guybrush", "Threepwood", 23);
        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Bernard Black]\n", $out );

        // The ID DID change, so change the name.
        $t->send->user = new TestUser("Guybrush", "Threepwood", 88);
        $out = $t->process( "cache_key_object.tpl");
        $this->assertEquals( "\n[Guybrush Threepwood]\n", $out );
    }


    public function testChangeTemplateThenRenewCache()
    {
        $t = new ezcTemplate();
        $t->send->name = "Bernard";

        $config = ezcTemplateConfiguration::getInstance();
        $config->templatePath = $this->tempDir;

        file_put_contents( $config->templatePath  . DIRECTORY_SEPARATOR . "blarp.tpl", '
{use $name}
{cache_template}
[{$name}]
' );


        $out = $t->process( "blarp.tpl");
        $this->assertEquals( "\n[Bernard]\n", $out );

        // Retry, the old name should be in the cached template.
        $t->send->name = "Guybrush";
        $out = $t->process( "blarp.tpl");
        $this->assertEquals( "\n[Bernard]\n", $out );
/*
        // Update the contents
        file_put_contents( $this->tempDir . DIRECTORY_SEPARATOR . "blarp.tpl", '
{use $name}
{cache_template}
[[[[[[{$name}]]]]]]
' );

        $t->send->name = "Guybrush";
        $out = $t->process( "blarp.tpl");
        $this->assertEquals( "\n[[[[[[Guybrush]]]]]]\n", $out );
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
