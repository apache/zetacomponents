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
class ezcTemplateVariableExceptionTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateVariableExceptionTest" );
    }

    /**
     * Test 'variable undefined' constructor values
     */
    public function testVariableUndefined()
    {
        $e = new ezcTemplateVariableUndefinedException( 'Zathras' );

        self::assertSame( "Undefined variable: <Zathras>", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'wrong type' constructor values
     */
    public function testWrongType()
    {
        $e = new ezcTemplateVariableWrongTypeException( 'Kosh', 'string', 'int' );

        self::assertSame( "Wrong type for variable: <Kosh>, expected: <string>, got: <int>", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test direction string generation
     */
    public function testDirectionStringGeneration()
    {
        foreach ( array( array( 'DIR_IN', ezcTemplateVariable::DIR_IN ),
                         array( 'DIR_OUT', ezcTemplateVariable::DIR_OUT ),
                         array( 'DIR_NONE', ezcTemplateVariable::DIR_NONE ) )
                  as $dirData )
        {
            self::assertSame( ezcTemplateVariableWrongDirectionException::directionName( $dirData[1] ), $dirData[0],
                              'Generated direction text is not correct' );
        }

        foreach ( array( 0, false, true, array(), '', '0', '1', 'abc' )
                  as $dir )
        {
            self::assertSame( 'UNKNOWN', ezcTemplateVariableWrongDirectionException::directionName( $dir ),
                              'Generated direction text is not correct for invalid value <' . gettype( $dir ) . ':' . $dir . '>' );
        }
    }

    /**
     * Test 'wrong direction' constructor values
     */
    public function testWrongDirection()
    {
        $e = new ezcTemplateVariableWrongDirectionException( 'Morden', ezcTemplateVariable::DIR_IN, ezcTemplateVariable::DIR_NONE );

        self::assertSame( "Wrong direction for variable: <Morden>, expected: <DIR_IN(1)>, got: <DIR_NONE(3)>", $e->getMessage(),
                          'Exception message is not correct' );
    }

}

?>
