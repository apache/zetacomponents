<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
