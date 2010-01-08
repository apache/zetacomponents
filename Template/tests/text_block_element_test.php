<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcTemplateTextBlockElementTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateTextBlockElementTest" );
    }

    /**
     * Test if escaped braces are properly handled in text blocks.
     */
    public function testEscapedBracesAreStrippedAway()
    {
        $textList = array( array( "simple text",
                                  "simple text" ),
                           array( "text with \\{ \\\\escaped// \\} braces",
                                  "text with { \\escaped// } braces" ) );
        foreach ( $textList as $text )
        {
            $source = new ezcTemplateSourceCode( '', '', $text[0] );
            $start = new ezcTemplateCursor( $source->code, 0, 1, 0 );
            $end = new ezcTemplateCursor( $source->code, strlen( $source->code ), 1, strlen( $source->code ) );
            $textElement = new ezcTemplateTextBlockTstNode( $source, $start, $end );
            /*self::assertThat( $textElement, self::objectHasAttribute( "text" )->that( self::identicalTo( $text[1] ) ),
                              "Stored text property does not matched expected value." );*/
            self::assertThat( ezcTemplateTextBlockTstNode::stripText( $text[0] ), self::identicalTo( $text[1] ),
                              "Stripped text does not matched expected value." );
        }
    }
}


?>
