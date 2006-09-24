<?php
/**
 * ezcConsoleToolsOptionTest
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOption class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsOptionTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsOptionTest" );
	}

    public function testAddDependencyExisting()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addDependency( $rule );
        $option_1->addDependency( $rule );

        $this->assertAttributeEquals(
            array( $rule ),
            "dependencies",
            $option_1
        );
    }

    // Bug #9052: Exception because of invalid property in ezcConsoleOption
    public function testRemoveDependency()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule_1 = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $rule_2 = new ezcConsoleOptionRule(
            $option_2, array( "d" )
        );

        $option_1->addDependency( $rule_1 );
        $option_1->addDependency( $rule_2 );
        $option_1->removeAllDependencies( $option_2 );

        $this->assertAttributeEquals(
            array(),
            "dependencies",
            $option_1
        );
    }

    // Bug #9052: Exception because of invalid property in ezcConsoleOption
    public function testHasDependency()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addDependency( $rule );

        $this->assertTrue(
            $option_1->hasDependency( $option_2 )
        );
    }
    
    public function testResetDependencies()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addDependency( $rule );
        $option_1->resetDependencies();

        $this->assertAttributeEquals(
            array(),
            "dependencies",
            $option_1
        );
    }
    
    public function testAddExclusionExisting()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addExclusion( $rule );
        $option_1->addExclusion( $rule );

        $this->assertAttributeEquals(
            array( $rule ),
            "exclusions",
            $option_1
        );
    }

    // Bug #9052: Exception because of invalid property in ezcConsoleOption
    public function testRemoveExclusion()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule_1 = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $rule_2 = new ezcConsoleOptionRule(
            $option_2, array( "d" )
        );

        $option_1->addExclusion( $rule_1 );
        $option_1->addExclusion( $rule_2 );
        $option_1->removeAllExclusions( $option_2 );

        $this->assertAttributeEquals(
            array(),
            "exclusions",
            $option_1
        );
    }

    // Bug #9052: Exception because of invalid property in ezcConsoleOption
    public function testHasExclusion()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addExclusion( $rule );

        $this->assertTrue(
            $option_1->hasExclusion( $option_2 )
        );
    }
    
    public function testResetExclusions()
    {
        $option_1 = new ezcConsoleOption(
            "a",
            "aaa"
        );
        $option_2 = new ezcConsoleOption(
            "b",
            "bbb"
        );

        $rule = new ezcConsoleOptionRule(
            $option_2, array( "c" )
        );

        $option_1->addExclusion( $rule );
        $option_1->resetExclusions();

        $this->assertAttributeEquals(
            array(),
            "exclusions",
            $option_1
        );
    }
}

?>
