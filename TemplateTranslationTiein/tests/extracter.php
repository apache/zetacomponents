<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcTemplateTranslationExtracterTest' );
    }
}

?>
