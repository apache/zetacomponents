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
class ezcTemplateVariableTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateVariableTest" );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $var = new ezcTemplateVariable( 'Sinclair Jeffrey' );

        self::assertSame( 'Sinclair Jeffrey', $var->name, 'Property <name> does not return correct value.' );
        self::assertSame( null, $var->value, 'Property <value> does not return correct value.' );
        self::assertSame( null, $var->type, 'Property <type> does not return correct value.' );
        self::assertSame( ezcTemplateVariable::DIR_NONE, $var->direction, 'Property <direction> does not return correct value.' );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $var = new ezcTemplateVariable( 'Sheridan John', 'Bruce Boxleitner', 'string', ezcTemplateVariable::DIR_IN );

        self::assertSame( 'Sheridan John', $var->name, 'Property <name> does not return correct value.' );
        self::assertSame( 'Bruce Boxleitner', $var->value, 'Property <value> does not return correct value.' );
        self::assertSame( 'string', $var->type, 'Property <type> does not return correct value.' );
        self::assertSame( ezcTemplateVariable::DIR_IN, $var->direction, 'Property <direction> does not return correct value.' );
    }
}

?>
