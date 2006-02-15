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
class ezcTemplateExecutionResultTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateExecutionResultTest" );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $execution = new ezcTemplateExecutionResult();

        self::assertSame( false, $execution->output, 'Property <output> does not return correct value.' );
        self::assertSame( array(), $execution->errors, 'Property <errors> does not return correct value.' );
        self::assertSame( null, $execution->variables, 'Property <variables> does not return correct value.' );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $execution = new ezcTemplateExecutionResult( 'test output', new ezcTemplateVariableCollection() );

        self::assertSame( 'test output', $execution->output, 'Property <output> does not return correct value.' );
        self::assertSame( array(), $execution->errors, 'Property <errors> does not return correct value.' );
        self::assertSame( 'ezcTemplateVariableCollection', get_class( $execution->variables ), 'Property <variables> is not correct class.' );
    }

    /**
     * Test adding error entries
     */
    public function testErrorEntries()
    {
        $execution = new ezcTemplateExecutionResult();

        $error1 = new ezcTemplateValidationItem( ezcTemplateValidationItem::TYPE_ERROR,
                                                 'templates/full.tpl', 2, 10,
                                                 'template contains errors', 'missing end marker }' );
        $error2 = new ezcTemplateValidationItem( ezcTemplateValidationItem::TYPE_WARNING,
                                                 'templates/full.tpl', 5, 4,
                                                 'possible problems with expression', 'unbalanced parenthesis in expression' );
        $execution->errors[] = $error1;
        $execution->errors[] = $error2;

        self::assertSame( false, $execution->output, 'Property <output> does not return correct value.' );
        self::assertSame( 'array', gettype( $execution->errors ), 'Property <errors> does contain an array.' );
        self::assertSame( $error1, $execution->errors[0], 'Property <errors> at index 0 does not return correct value.' );
        self::assertSame( $error2, $execution->errors[1], 'Property <errors> at index 0 does not return correct value.' );
        self::assertSame( null, $execution->variables, 'Property <variables> does not return correct value.' );
    }

    /**
     * Test turning object into strings
     */
    public function testToString()
    {
        $execution = new ezcTemplateExecutionResult( false );
        self::assertSame( '', $execution->__toString(), 'Execution does not properly turn into a string.' );

        $execution = new ezcTemplateExecutionResult( 'abc' );
        self::assertSame( 'abc', $execution->__toString(), 'Execution does not properly turn into a string.' );
    }
}

?>
