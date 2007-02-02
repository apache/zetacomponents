<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
    
    // /////////////////////////////////////////////////////////////////////////////////////////
    // Cache block is not implemented, and should give an exception.

    public function testCacheBlock()
    {
        $t = new ezcTemplate( );
        $t->send->user = new TestUser( "Bernard", "Black" );

        try
        {
            $out = $t->process( "cache_block.tpl");
            $this->fail( "{cache_block} should throw an exception");
        }
        catch ( ezcTemplateParserException $e )
        {
        }
    }



    // /////////////////////////////////////////////////////////////////////////////////////////
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


    public function testDynamicBlockWithSingleQuote()
    {
        $t = new ezcTemplate( );
        $t->send->user = new TestUser( "Bernard", "Black" );
        $out = $t->process( "cache_dynamic_single_quote.tpl");

        $this->assertEquals( "\n'Bernard'\n'Bernard' \\'\n", $out );

        $t->send->user = new TestUser( "Guybrush", "Threepwood", 10 );
        $out = $t->process( "cache_dynamic_single_quote.tpl");

        $this->assertEquals( "\n'Bernard'\n'Guybrush' \\'\n", $out );
    }

    // Declare a variable under the first dynamic block.
    public function testDynamicBlockVariableDeclaration()
    {
        $t = new ezcTemplate( );
        $t->send->number = 22; 
        $out = $t->process( "cache_dynamic_var_declare.tpl");

        $this->assertEquals( "\n[22]\n6\n", $out);

        $t->send->user = new TestUser( "Guybrush", "Threepwood", 10 );
        $out = $t->process( "cache_dynamic_advanced.tpl");

        $this->assertEquals( "\n[2]\n[Guybrush Threepwood]\n[Nr 2]\n[Guybrush Threepwood]\n[Nr 3]\n[13]\n[Guybrush Threepwood]\n", $out );
        
    }

    // Declare a variable under the first dynamic block.
    public function testDynamicBlockImplicitVariableDeclaration()
    {
        $t = new ezcTemplate( );
        $t->send->number = 22; 
        $t->process( "cache_dynamic_implicit_declaration.tpl");

 //       $this->assertEquals( "\n22\n5\n6\n", $t->output );

//        $t->send->number = 23; 
  //      $t->process( "cache_dynamic_implicit_declaration.tpl");

   //     $this->assertEquals( "\n23\n5\n6\n", $t->output );

    }




    // /////////////////////////////////////////////////////////////////////////////////////////////////
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

    // /////////////////////////////////////////////////////////////////////////////////////////////////
    // Test TTL

    public function testTimeToLive()
    {
        $timerAtStart = time();

        $t = new ezcTemplate();
        $t->send->username = "Bernard";
        $out = $t->process( "cache_ttl.tpl");
        $this->assertEquals( "\n[Bernard]\n", $out );
 
        // Rerun.
        $t->send->username = "Guybrush";
        $out = $t->process( "cache_ttl.tpl");

        $timerAfterRerun = time();

        while (time() - $timerAfterRerun < 2 )
        {
            // $this->assertEquals( "\n[Bernard]\n", $out );
            usleep( 300000 ); // 300 ms.
            // $out = $t->process( "cache_ttl.tpl");
        }

        // Check whether the template is removed after the TTL exceeded.
        $out = $t->process( "cache_ttl.tpl");
        $this->assertEquals( "\n[Guybrush]\n", $out );
    }



    // /////////////////////////////////////////////////////////////////////////////////////////////////
    // General
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

        sleep(1); // Make sure that the mtime is changed.

        // Update the contents
        file_put_contents( $this->tempDir . DIRECTORY_SEPARATOR . "blarp.tpl", '
{use $name}
{cache_template}
[[[[[[{$name}]]]]]]
' );

        $t->send->name = "Guybrush";
        $out = $t->process( "blarp.tpl");
        $this->assertEquals( "\n[[[[[[Guybrush]]]]]]\n", $out );
    }


    public function testReturnStatementsInCache()
    {
        $t = new ezcTemplate();
        $t->send->number = 0;

        $t->receive->x = null;
        $t->process( "cache_return.tpl");
        $this->assertEquals( "\n[0]\n", $t->output);
        $this->assertEquals( "Zero", $t->receive->x);

        $t->receive->x = null;
        $t->send->number = 1;
        $t->process( "cache_return.tpl");
        $this->assertEquals( "\n[0]\n", $t->output);
        $this->assertEquals( "Zero", $t->receive->x);
    }



    public function testDynamicReturnStatementsInCache()
    {
        $t = new ezcTemplate();
        $t->send->number = 0;

        $t->receive->x = null;
        $t->process( "cache_dynamic_return.tpl");
        $this->assertEquals( "\n[0]\n", $t->output);
        $this->assertEquals( "Zero", $t->receive->x);

        $t->receive->x = null;
        $t->send->number = 1;
        $t->process( "cache_dynamic_return.tpl");
        $this->assertEquals( "\n[0]\n", $t->output);
        $this->assertEquals( "One", $t->receive->x);
    }

    public function testDynamicReturnStatementInCache2()
    {
        $t = new ezcTemplate();
        $t->send->number = 2;

        // Call the non dynamic part.
        $t->process( "cache_dynamic_return2.tpl");
        $this->assertEquals( "\n[2]\n\n\n", $t->output);
        $this->assertEquals( "Not one", $t->receive->numberStr);
        $this->assertEquals( "4", $t->receive->calc);
        $this->assertEquals( "I am rubber, you are glue.", $t->receive->quote);
        
        $t->receive->quote = null;
        $t->receive->calc = null;
        $t->receive->numberStr = null;

        // Everything should still be cached.
        $t->send->number = 3;
        $t->process( "cache_dynamic_return2.tpl");
        $this->assertEquals( "\n[2]\n\n\n", $t->output);
        $this->assertEquals( "Not one", $t->receive->numberStr);
        $this->assertEquals( "4", $t->receive->calc);
        $this->assertEquals( "I am rubber, you are glue.", $t->receive->quote);

        $t->receive->quote = null;
        $t->receive->calc = null;
        $t->receive->numberStr = null;

        // Partly cached, partly dynamic. 
        $t->send->number = 1;
        $t->process( "cache_dynamic_return2.tpl");
        $this->assertEquals( "\n[2]\n\n", $t->output); // Cached.
        $this->assertEquals( "One", $t->receive->numberStr);
        $this->assertEquals( 2, $t->receive->calc);
        $this->assertEquals( "You fight like a drairy farmer.", $t->receive->quote);
    }

    public function testIncludeStatementInCache()
    {
        $t = new ezcTemplate();
        $t->send->a = 2;
        $t->send->b = 10;
        $t->process( "cache_include.tpl");
        
        $this->assertEquals( "\n\n[2]\n[10]\n\n<2>\n<10>\n<Hello>\n<World>\n[Included template]\n\n[42]\n[12]\n", $t->output);
        
        $t->send->a = 3;
        $t->send->b = 11;
        $t->process( "cache_include.tpl");
        $this->assertEquals( "\n\n[2]\n[10]\n\n<2>\n<10>\n<Hello>\n<World>\n[Included template]\n\n[42]\n[12]\n", $t->output);
    }


    public function testDynamicIncludeStatementInCache()
    {
        $t = new ezcTemplate();
        $t->send->a = 2;
        $t->send->b = 10;

        // Call the non dynamic part.
        $t->process( "cache_dynamic_include.tpl");

        $this->assertEquals( "\n\n[2]\n[10]\n\n<2>\n<10>\n<Hello>\n<World>\n[Included template]\n[42]\n[12]\n\n[42]\n[12]\n", $t->output );

        $t->send->a = 3;
        $t->send->b = 11;
        $t->process( "cache_dynamic_include.tpl");
        $this->assertEquals( "\n\n[2]\n[10]\n\n<3>\n<11>\n<Hello>\n<World>\n[Included template]\n[42]\n[13]\n\n[42]\n[12]\n", $t->output );

        
        // $this->assertEquals( "\n[2]\n\n\n", $t->output);
        // $this->assertEquals( "Not one", $t->receive->numberStr);
        // $this->assertEquals( "4", $t->receive->calc);
        // $this->assertEquals( "I am rubber, you are glue.", $t->receive->quote);
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
