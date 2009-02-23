<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */

/**
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */
class ezcTemplateTranslationExtracterTest extends ezcTestCase
{
    function testExtracter()
    {
        $file = dirname( __FILE__ ) . '/test_files/test.ezt';
        $source = new ezcTemplateSourceCode( $file, $file );
        $source->load();

        $parser = new ezcTemplateParser( $source, new ezcTemplate() );
        $tst = $parser->parseIntoNodeTree();

        $et = new ezcTemplateTranslationStringExtracter( $parser );
        $eted = $tst->accept( $et );

        $tr = $et->getTranslation();
        self::assertEquals( 
            array( 'een', 'twee', 'drie', 'vier', 'vijf', 'zes', 'zeven', 'acht', 'negen', 'tien', 'elf' ),
            array_keys( $this->readAttribute( $tr['test'], 'translationMap' ) ) 
        );
    }

    function testExtracterWithoutDefaultContext()
    {
        $file = dirname( __FILE__ ) . '/test_files/test_without_default_context.ezt';
        $source = new ezcTemplateSourceCode( $file, $file );
        $source->load();

        $parser = new ezcTemplateParser( $source, new ezcTemplate() );
        $tst = $parser->parseIntoNodeTree();

        $et = new ezcTemplateTranslationStringExtracter( $parser );
        $eted = $tst->accept( $et );

        $tr = $et->getTranslation();
        self::assertEquals( 
            array( 'een', 'twee', 'drie', 'vier', 'vijf', 'zes', 'zeven', 'acht', 'negen', 'tien', 'elf' ),
            array_keys( $this->readAttribute( $tr['test'], 'translationMap' ) ) 
        );
    }

    function testExtracterWithoutContext()
    {
        $file = dirname( __FILE__ ) . '/test_files/test_without_context.ezt';
        $source = new ezcTemplateSourceCode( $file, $file );
        $source->load();

        $parser = new ezcTemplateParser( $source, new ezcTemplate() );
        $tst = $parser->parseIntoNodeTree();

        $et = new ezcTemplateTranslationStringExtracter( $parser );
        try
        {
            $eted = $tst->accept( $et );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcTemplateParserException $e )
        {
            self::assertEquals( "$file:3:11: Expecting a 'context' parameter, or a default context set with {tr_context}.\n\n{tr \"een\"}\n          ^\n", $e->getMessage() );
        }
    }

    function testExtracterWithQuotes()
    {
        $file = dirname( __FILE__ ) . '/test_files/test-quotes.ezt';
        $source = new ezcTemplateSourceCode( $file, $file );
        $source->load();

        $parser = new ezcTemplateParser( $source, new ezcTemplate() );
        $tst = $parser->parseIntoNodeTree();

        $et = new ezcTemplateTranslationStringExtracter( $parser );
        $eted = $tst->accept( $et );

        $tr = $et->getStrings();

        self::assertEquals( 
            array( 'Test quotes: \'test\'.', 'Test quotes: "test".', 'Test quotes: \'test\' "test".', 'Test quotes: "test" \'test\'.' ),
            array_keys( $tr['un'] ) 
        );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcTemplateTranslationExtracterTest' );
    }
}

?>
