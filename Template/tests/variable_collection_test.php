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
class ezcTemplateVariableCollectionTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateVariableCollectionTest" );
    }

    /**
     * Creates a set of variables and a collection for testing.
     */
    public function setUp()
    {
        $this->var1 = new ezcTemplateVariable( 'Sinclair Jeffrey' );
        $this->var2 = new ezcTemplateVariable( 'Sheridan John', 'Bruce Boxleitner', 'string', ezcTemplateVariable::DIR_IN );
        $this->var3 = new ezcTemplateVariable( 'Ivanova Susan', 'Claudia Christian', 'string', ezcTemplateVariable::DIR_OUT );
        $this->vars = array( $this->var1->name => $this->var1,
                             $this->var2->name => $this->var2,
                             $this->var3->name => $this->var3 );
        $this->normalVars = array( $this->var1->name => $this->var1 );
        $this->inputVars = array( $this->var2->name => $this->var2 );
        $this->outputVars = array( $this->var3->name => $this->var3 );
        $this->col = new ezcTemplateVariableCollection( $this->vars );
    }

    /**
     * Unsets all variables
     */
    public function tearDown()
    {
        unset( $this->var1, $this->var2, $this->var3,
               $this->vars, $this->normalVars, $this->inputVars, $this->outputVars,
               $this->col );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $col = new ezcTemplateVariableCollection();
        $colArray = (array)$col;
        self::assertSame( array(), $colArray["\0ezcTemplateVariableCollection\0variables"],
                          'Private property <varibles> does not contain initialised empty array.' );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $colArray = (array)$this->col;
        self::assertSame( $this->vars, $colArray["\0ezcTemplateVariableCollection\0variables"],
                          'Private property <variables> does not contain initialised collection.' );
    }

    /**
     * Test hasVariable() method.
     */
    public function testHasVariable()
    {
        // check for variables that should be present
        self::assertSame( true, $this->col->hasVariable( 'Sinclair Jeffrey' ),
                          "hasVariable( 'Sinclair Jeffrey' ) did not return true." );
        self::assertSame( true, $this->col->hasVariable( 'Sheridan John' ),
                          "hasVariable( 'Sheridan John' ) did not return true" );

        // check for varible which is not present
        self::assertSame( false,$this->col->hasVariable( 'Delenn' ),
                          "hasVariable( 'Delenn' ) did not return false" );
    }

    /**
     * Test extracting variables and checking the object data.
     */
    public function testExtractVariable()
    {
        // check variable extraction
        self::assertType( 'ezcTemplateVariable', $this->col->getVariable( 'Sinclair Jeffrey' ),
                          "getVariable( 'Sinclair Jeffrey' ) did not return an object of class ezcTemplateVariable." );
        self::assertType( 'ezcTemplateVariable', $this->col->getVariable( 'Sheridan John' ),
                          "getVariable( 'Sheridan John' ) did not return an object of class ezcTemplateVariable." );
        self::assertType( 'ezcTemplateVariable', $this->col->getVariable( 'Ivanova Susan' ),
                          "getVariable( 'Ivanova Susan' ) does return an object of class ezcTemplateVariable." );

        self::assertSame( $this->var1, $this->col->getVariable( 'Sinclair Jeffrey' ),
                          "getVariable( 'Sinclair Jeffrey' ) does not match original template variable." );
        self::assertSame( $this->var2, $this->col->getVariable( 'Sheridan John' ),
                          "getVariable( 'Sheridan John' ) match" );
        self::assertSame( $this->var3, $this->col->getVariable( 'Ivanova Susan' ),
                          "getVariable( 'Ivanova Susan' ) match" );

        // try to extract undefined variable
        try
        {
            $this->col->getVariable( 'Delenn' );
            self::fail( "Extracting undefined variable 'Delenn' did not give an exception." );
        }
        catch ( ezcTemplateVariableUndefinedException $e )
        {
        }
    }

    /**
     * Test extracting variable lists.
     */
    public function testAllVariables()
    {
        // check that we have all the variables present as associative array and name list
        self::assertSame( $this->vars, $this->col->getAllVariables(),
                          "getAllVariables() did not return all variables." );
        self::assertSame( array_keys( $this->vars ), $this->col->getVariableNames(),
                          "getVariableNames() did not return variable names." );

        // check for output variables
        self::assertSame( $this->outputVars, $this->col->getOutputVariables(),
                          "getOutputVariables() did not return output variables." );

        // check for input variables
        self::assertSame( $this->inputVars, $this->col->getInputVariables(),
                          "getInputVariables() did not return input variables." );

        // check for normal variables
        self::assertSame( $this->normalVars, $this->col->getVariables(),
                          "getVariables() did not return normal variables." );
    }

    /**
     * Test removing defined variables.
     */
    public function testRemoveVariable()
    {
        // remove variable and check that it is no longer present
        $this->col->removeVariable( 'Sinclair Jeffrey' );
        self::assertSame( false, $this->col->hasVariable( 'Sinclair Jeffrey' ), "hasVariable( 'Sinclair Jeffrey' ) was not supposed to return true." );

        // try to remove undefined variable
        try
        {
            $this->col->removeVariable( 'Sinclair Jeffrey' );
            self::fail( "Removing variable 'Sinclair Jeffrey' twice was possible, should not happen." );
        }
        catch ( ezcTemplateVariableUndefinedException $e )
        {
        }
    }

    /**
     * Test resetting the variable list with empty and filled in list.
     */
    public function testResetVariables()
    {
        // reset variable list and check that is empty
        $this->col->resetVariables();
        self::assertSame( array(), $this->col->getAllVariables(),
                          "resetVariables() did not clear the variable list." );

        // reset variable list with old variables and check that they are present
        $this->col->resetVariables( $this->vars );
        self::assertSame( $this->vars, $this->col->getAllVariables(),
                          "resetVariables(\$vars) did not initialise the variable list with the new array." );
    }

    /**
     * Test setting variable objects and checking the result afterwards.
     */
    public function testSetVariables()
    {
        $this->col->resetVariables();

        // set back variables and check them with getVariable()
        $this->col->setVariable( $this->var3 );
        self::assertSame( $this->var3, $this->col->getVariable( 'Ivanova Susan' ),
                          "setVariable( 'Ivanova Susan' ) did not register the variable." );

        $this->col->setVariable( $this->var2 );
        self::assertSame( $this->var2, $this->col->getVariable( 'Sheridan John' ),
                          "setVariable( 'Sheridan John' ) did not register the variable." );

        $this->col->setVariable( $this->var1 );
        self::assertSame( $this->var1, $this->col->getVariable( 'Sinclair Jeffrey' ),
                          "setVariable( 'Sinclair Jeffrey' ) did not register the variable." );

        // check for output, input and normal variables
        self::assertSame( $this->outputVars, $this->col->getOutputVariables(),
                          "getOutputVariables() did not return the output variables which were registered." );
        self::assertSame( $this->inputVars, $this->col->getInputVariables(),
                          "getInputVariables() did not return the input variables which were registered." );
        self::assertSame( $this->normalVars, $this->col->getVariables(),
                          "getVariables() did not return the normal variables which were registered." );

        // overwrite variables with different content and check the result
        $this->col->removeVariable( $this->var2->name );
        $this->col->removeVariable( $this->var1->name );
        $this->col->removeVariable( $this->var3->name );

        $this->var2->name = 'Ivanova Susan';
        $this->col->setVariable( $this->var2 );
        self::assertSame( $this->var2, $this->col->getVariable( 'Ivanova Susan' ),
                          "setVariable( 'Ivanova Susan' ) did not register the variable with the new value." );

        $this->var1->name = 'Sheridan John';
        $this->col->setVariable( $this->var1 );
        self::assertSame( $this->var1, $this->col->getVariable( 'Sheridan John' ),
                          "setVariable( 'Sheridan John' ) did not register the variable with the new value." );

        $this->var3->name = 'Sinclair Jeffrey';
        $this->col->setVariable( $this->var3 );
        self::assertSame( $this->var3, $this->col->getVariable( 'Sinclair Jeffrey' ),
                          "setVariable( 'Sinclair Jeffrey' ) did not register the variable with the new value." );

        // check for variables again
        $outputVars = array( 'Sinclair Jeffrey' => $this->var3 );
        self::assertSame( $outputVars, $this->col->getOutputVariables(),
                          "getOutputVariables() did not return the output variables which were registered with new values." );
        $inputVars = array( 'Ivanova Susan' => $this->var2 );
        self::assertSame( $inputVars, $this->col->getInputVariables(),
                          "getInputVariables() did not return the input variables which were registered with new values." );
        $normalVars = array( 'Sheridan John' => $this->var1 );
        self::assertSame( $normalVars, $this->col->getVariables(),
                          "getVariables() did not return the normal variables which were registered with new values." );
    }

    /**
     * Test defining input variables and checking the variable data afterwards.
     */
    public function testDefineInputVariable()
    {
        $this->col->resetVariables();

        // define an input variable and check the result with getVariable()
        foreach ( array( 'Michael OHare', '', '0', '1', false, true,
                         array(), array( 1 ), new Exception( "", 0 ) )
                  as $value )
        {
            $this->col->defineInput( 'Sinclair Jeffrey', $value );
            $var3 = $this->col->getVariable( 'Sinclair Jeffrey' );
            self::assertSame( 'ezcTemplateVariable', get_class( $var3 ),
                              "defineInput( 'Sinclair Jeffrey' ) did not create an ezcTemplateVariable object." );
            self::assertSame( 'Sinclair Jeffrey', $var3->name,
                              "defineInput( 'Sinclair Jeffrey' ) did not create variable with correct <name> property." );
            self::assertSame( $value, $var3->value,
                              "defineInput( 'Sinclair Jeffrey' ) did not create variable with correct <value> property." );
            self::assertSame( null, $var3->type,
                              "defineInput( 'Sinclair Jeffrey' ) did not create variable with correct <type> property." );
            self::assertSame( ezcTemplateVariable::DIR_IN, $var3->direction,
                              "defineInput( 'Sinclair Jeffrey' ) did not create variable with correct <direction> property." );
        }
    }

    /**
     * Test defining output variables and checking the variable data afterwards.
     */
    public function testDefineOutputVariable()
    {
        $this->col->resetVariables();

        // define an output variable and check the result with getVariable()
        $this->col->defineOutput( 'Ivanova Susan' );
        $var3 = $this->col->getVariable( 'Ivanova Susan' );
        self::assertSame( 'ezcTemplateVariable', get_class( $var3 ),
                          "defineVariable( 'Sinclair Jeffrey' ) did not create an ezcTemplateVariable object." );
        self::assertSame( 'Ivanova Susan', $var3->name,
                          "defineOutput( 'Ivanova Susan' ) did not create variable with correct <name> property." );
        self::assertSame( null, $var3->value,
                          "defineOutput( 'Ivanova Susan' ) did not create variable with correct <value> property." );
        self::assertSame( null, $var3->type,
                          "defineOutput( 'Ivanova Susan' ) did not create variable with correct <type> property." );
        self::assertSame( ezcTemplateVariable::DIR_OUT, $var3->direction,
                          "defineOutput( 'Ivanova Susan' ) did not create variable with correct <direction> property." );
    }

    /**
     * Test defining normal variables and checking the variable data afterwards.
     */
    public function testDefineNormalVariable()
    {
        $this->col->resetVariables();

        // define an output variable and check the result with getVariable()
        foreach ( array( 'Bruce Boxleitner', '', '0', '1', false, true,
                         array(), array( 1 ), new Exception( "", 0 ) )
                  as $value )
        {
            $this->col->defineVariable( 'Sheridan John', $value );
            $var3 = $this->col->getVariable( 'Sheridan John' );
            self::assertSame( 'ezcTemplateVariable', get_class( $var3 ),
                              "defineVariable( 'Sinclair Jeffrey' ) did not create an ezcTemplateVariable object." );
            self::assertSame( 'Sheridan John', $var3->name,
                              "defineVariable( 'Sheridan John' ) did not create variable with correct <name> property." );
            self::assertSame( $value, $var3->value,
                              "defineVariable( 'Sheridan John' ) did not create variable with correct <value> property." );
            self::assertSame( null, $var3->type,
                              "defineVariable( 'Sheridan John' ) did not create variable with correct <type> property." );
            self::assertSame( ezcTemplateVariable::DIR_NONE, $var3->direction,
                              "defineVariable( 'Sheridan John' ) did not create variable with correct <direction> property." );
        }
    }

    /**
     * Test checking the values of variables by their correct direction type.
     */
    public function testVariableValues()
    {
        self::assertSame( null, $this->col->getVariableValue( 'Sinclair Jeffrey' ),
                          "getVariableValue( 'Sinclair Jeffrey' ) did not return correct value." );
        self::assertSame( 'Bruce Boxleitner', $this->col->getInputValue( 'Sheridan John' ),
                          "getInputValue( 'Sheridan John' ) did not return correct value." );
        self::assertSame( 'Claudia Christian', $this->col->getOutputValue( 'Ivanova Susan' ),
                          "getOutputValue( 'Ivanova Susan' ) did not return correct value." );
    }

    /**
     * Test checking the values of variables by their incorrect direction type.
     */
    public function testVariableValueFailures()
    {
        try
        {
            $this->col->getInputValue( 'Sinclair Jeffrey' );
            self::fail( "getInputValue( 'Sinclair Jeffrey' ) should not work, it is a normal variable." );
        }
        catch ( ezcTemplateVariableWrongDirectionException $e )
        {
        }

        try
        {
            $this->col->getOutputValue( 'Sheridan John' );
            self::fail( "getOutputValue( 'Sheridan John' ) should not work, it is an input variable." );
        }
        catch ( ezcTemplateVariableWrongDirectionException $e )
        {
        }

        try
        {
            $this->col->getVariableValue( 'Ivanova Susan' );
            self::fail( "getVariableValue( 'Ivonava Susan' ) should not work, it is an output variable." );
        }
        catch ( ezcTemplateVariableWrongDirectionException $e )
        {
        }
    }

    /**
     * Test if varibles has correct values.
     */
    public function testHasVariableValue()
    {
        self::assertSame( false, $this->col->hasVariableValue( 'Sinclair Jeffrey' ),
                          "hasVariableValue( 'Sinclair Jeffrey' ) should return false since the variable has no value (null)." );
        self::assertSame( true, $this->col->hasVariableValue( 'Sheridan John' ),
                          "hasVariableValue( 'Sheridan John' ) should return true since the variable has a value (non-null)." );
        self::assertSame( true, $this->col->hasVariableValue( 'Ivanova Susan' ),
                          "hasVariableValue( 'Ivanova Susan' ) should return true since the variable has a value (non-null)." );
    }
}

?>
