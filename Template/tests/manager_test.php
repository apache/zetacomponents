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
class ezcTemplateManagerTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateManagerTest" );
    }

    /**
     * Create some variables which point to the correct template directory.
     * This is prepended to all created path values to ensure tests where
     * they are installed.
     */
    public function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

    /**
     * Creates manager with initialised values and check the properties.
     */
    public function testInit()
    {
        $manager = new ezcTemplateManager();

        self::assertTrue( isset( $manager->configuration ),
                          'Property <configuration> is missing' );
        self::assertSame( 'ezcTemplateConfiguration', get_class( $manager->configuration ),
                          'Property <configuration>' );

        self::assertTrue( isset( $manager->defaultContext ),
                          'Property <defaultContext> is missing' );
        self::assertSame( true, $manager->defaultContext instanceof ezcTemplateOutputContext,
                          'Property <defaultContext>' );

        self::assertTrue( isset( $manager->outputDebugEnabled ), 'Property <outputDebugEnabled> is missing' );
        self::assertSame( false, $manager->outputDebugEnabled, 'Property <outputDebugEnabled>' );

        self::assertTrue( isset( $manager->compiledDebugEnabled ), 'Property <compiledDebugEnabled> is missing' );
        self::assertSame( false, $manager->compiledDebugEnabled, 'Property <compiledDebugEnabled>' );
    }

    public function testDefineInputVariable()
    {
        $manager = new ezcTemplateManager();

        $manager->defineInput( 'Garibaldi Michael', 'Jerry Doyle' );

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( true, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in variable collection for the manager." );
        $variable = $variables->getVariable( 'Garibaldi Michael' );
        self::assertSame( 'Garibaldi Michael', $variable->name,
                          "Defined input variable does not have correct <name> property." );
        self::assertSame( 'Jerry Doyle', $variable->value,
                          "Defined input variable does not have correct <value> property." );
        self::assertSame( null, $variable->type,
                          "Defined input variable does not have correct <type> property." );
        self::assertSame( ezcTemplateVariable::DIR_IN, $variable->direction,
                          "Defined input variable does not have correct <direction> property." );
    }


    public function testHasVariable()
    {
        $manager = new ezcTemplateManager();

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( false, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> exists in variable collection for the manager." );
        self::assertSame( false, $manager->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> exists in manager." );


        $manager->defineInput( 'Garibaldi Michael', 'Jerry Doyle' );

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( true, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in variable collection for the manager." );
        self::assertSame( true, $manager->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in manager." );

        $variable = $variables->getVariable( 'Garibaldi Michael' );
        self::assertSame( 'Garibaldi Michael', $variable->name,
                          "Defined input variable does not have correct <name> property." );
        self::assertSame( 'Jerry Doyle', $variable->value,
                          "Defined input variable does not have correct <value> property." );
        self::assertSame( null, $variable->type,
                          "Defined input variable does not have correct <type> property." );
        self::assertSame( ezcTemplateVariable::DIR_IN, $variable->direction,
                          "Defined input variable does not have correct <direction> property." );
    }

    public function testDefineOutputVariable()
    {
        $manager = new ezcTemplateManager();

        $manager->defineOutput( 'Garibaldi Michael' );

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( true, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in variable collection for the manager." );
        $variable = $variables->getVariable( 'Garibaldi Michael' );
        self::assertSame( 'Garibaldi Michael', $variable->name,
                          "Defined input variable does not have correct <name> property." );
        self::assertSame( null, $variable->value,
                          "Defined input variable does not have correct <value> property." );
        self::assertSame( null, $variable->type,
                          "Defined input variable does not have correct <type> property." );
        self::assertSame( ezcTemplateVariable::DIR_OUT, $variable->direction,
                          "Defined input variable does not have correct <direction> property." );
    }

    public function testRemoveVariable()
    {
        $manager = new ezcTemplateManager();

        $manager->defineInput( 'Garibaldi Michael', 'Jerry Doyle' );
        $manager->defineInput( 'Cotto Vir', 'Stephen Furst' );
        $manager->defineOutput( 'Alexander Lyta' );

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( true, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Cotto Vir' ),
                          "Defined input variable <Cotto Vir> does not exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Alexander Lyta' ),
                          "Defined input variable <Alexander Lyta> does not exist in variable collection for the manager." );

        $manager->removeVariable( 'Garibaldi Michael' );
        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( false, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Removed input variable <Garibaldi Michael> still exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Cotto Vir' ),
                          "Defined input variable <Cotto Vir> does not exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Alexander Lyta' ),
                          "Defined input variable <Alexander Lyta> does not exist in variable collection for the manager." );
    }

    public function testResetVariable()
    {
        $manager = new ezcTemplateManager();

        $manager->defineInput( 'Garibaldi Michael', 'Jerry Doyle' );
        $manager->defineInput( 'Cotto Vir', 'Stephen Furst' );
        $manager->defineOutput( 'Alexander Lyta' );

        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( true, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Defined input variable <Garibaldi Michael> does not exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Cotto Vir' ),
                          "Defined input variable <Cotto Vir> does not exist in variable collection for the manager." );
        self::assertSame( true, $variables->hasVariable( 'Alexander Lyta' ),
                          "Defined input variable <Alexander Lyta> does not exist in variable collection for the manager." );

        $manager->resetVariables();
        $managerArray = (array)$manager;
        $variables = $managerArray["\0ezcTemplateManager\0variables"];
        self::assertSame( false, $variables->hasVariable( 'Garibaldi Michael' ),
                          "Removed input variable <Garibaldi Michael> still exist in variable collection for the manager." );
        self::assertSame( false, $variables->hasVariable( 'Cotto Vir' ),
                          "Removed input variable <Cotto Vir> does not exist in variable collection for the manager." );
        self::assertSame( false, $variables->hasVariable( 'Alexander Lyta' ),
                          "Removed input variable <Alexander Lyta> does not exist in variable collection for the manager." );
    }

    /**
     * Check that the generateOptionHash() creates unique hashes. This is done
     * by going trough all possible combinations and creating the hashes, then
     * matching them against previous created. No duplicates should be found.
     */
    public function testUniqueOptionHash()
    {
        $manager = new ezcTemplateManager();

        // the possible values for each option
        $outputValues = array( true, false );
        $compiledValues = array( true, false );

        // all combinations with the property to modify
        $testValues = array( array( 'values' => $outputValues,
                                    'property' => 'outputDebugEnabled' ),
                             array( 'values' => $compiledValues,
                                    'property' => 'compiledDebugEnabled' ) );


        self::assertTrue( count( $testValues ) > 0 );

        // Figure out total combinations possible
        $maxIterations = count( $testValues[0]['values'] );
        for ( $i = 1; $i < count( $testValues ); ++$i )
        {
            $count = count( $testValues[$i]['values'] );
            self::assertTrue( $count > 0 );
            $maxIterations *= $count;
        }

        $optionHashList = array();

        // Go trough all cominations by using iteration number for
        // index of each value list.
        for ( $i = 0; $i < $maxIterations; ++$i )
        {
            $tmp = $i;
            $testedValues = array();
            foreach ( $testValues as $testValue )
            {
                $count = count( $testValue['values'] );
                self::assertTrue( $count > 0 );
                $index = $tmp % $count;
                $tmp = (int)( $tmp / $count );

                self::assertTrue( isset( $manager->$testValue['property'] ) );
                $manager->$testValue['property'] = $testValue['values'][$index];

                $testedValues[] = array( $testValue['property'] => $testValue['values'][$index] );
            }
            $hash = $manager->generateOptionHash();
            self::assertNotContains( $hash, $optionHashList,
                                     "The option hash <$hash> was found among old values, used values <" . var_export( $testedValues, true ) . ">" );
            $optionHashList[] = $hash;
        }
    }

//     public function testFindSource()
//     {
//         throw new PHPUnit2_Framework_IncompleteTestError;
//     }

//     public function testFindCompiled()
//     {
//         throw new PHPUnit2_Framework_IncompleteTestError;
//     }

     public function testProcess()
     {
 //        $manager = new ezcTemplateManager();
 //        $manager->configuration = new ezcTemplateConfiguration( $this->templatePath, $this->templateCompiledPath );

 //        $inputVariables = new ezcTemplateVariableCollection();
 //        //$manager->setVariable( "a", 42 );
 //        $result = $manager->process( $this->templatePath . "ordinary_text.tpl" );

 //        self::assertEquals ( $result->output, "Hello world\n");

         /*
         self::assertSame( 'ezcTemplateExecutionResult', get_class( $result ),
                           'ezcTemplateManager::process did not return valid object' );
                           */
     }
}

?>
