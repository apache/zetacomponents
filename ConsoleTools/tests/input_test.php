<?php
/**
 * ezcConsoleInputTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleInput class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleInputTest extends ezcTestCase
{
    private $testOptions = array( 
        array( 
            'short'     => 't',
            'long'      => 'testing',
            'options'   => array(),
        ),
        array( 
            'short'     => 's',
            'long'      => 'subway',
            'options'   => array(),
        ),
        array( 
            'short'     => '',
            'long'      => 'carry',
            'options'   => array(),
        ),
        array( 
            'short'     => 'v',
            'long'      => 'visual',
            'options'   => array(
                'multiple'  => true,
                'arguments' => false,
            ),
        ),
        array( 
            'short'     => 'o',
            'long'      => 'original',
            'options'   => array(
                'type'      => ezcConsoleInput::TYPE_STRING,
            ),
        ),
        array( 
            'short'     => 'b',
            'long'      => 'build',
            'options'   => array(
                'type'      => ezcConsoleInput::TYPE_INT,
                'default'   => 42,
            ),
        ),
        array( 
            'short'     => 'd',
            'long'      => 'destroy',
            'options'   => array(
                'type'      => ezcConsoleInput::TYPE_STRING,
                'default'   => 'world',
            ),
        ),
        array( 
            'short'     => 'y',
            'long'      => 'yank',
            'options'   => array(
                'type'          => ezcConsoleInput::TYPE_STRING,
                'multiple'      => true,
                'shorthelp'     => 'Some stupid short text.',
                'longhelp'      => 'Some even more stupid, but somewhat longer long describtion.',
            ),
        ),
        array( 
            'short'     => 'c',
            'long'      => 'console',
            'options'   => array(
                'shorthelp'     => 'Some stupid short text.',
                'longhelp'      => 'Some even more stupid, but somewhat longer long describtion.',
                'depends'       => array( 't', 'o', 'b', 'y' ),
            ),
        ),
        array( 
            'short'     => 'e',
            'long'      => 'edit',
            'options'   => array(
                'excludes'      => array( 't', 'y' ),
                'arguments'     => false,
            ),
        ),
        array( 
            'short'     => 'n',
            'long'      => 'new',
            'options'   => array(
                'depends'       => array( 't', 'o' ),
                'excludes'      => array( 'b', 'y' ),
                'arguments'     => false,
            ),
        ),
    );

    private $testAliasesSuccess = array( 
        array(
            'short' => 'k',
            'long'  => 'kelvin',
            'ref'   => 't',
        ),
        array(
            'short' => 'f',
            'long'  => 'foobar',
            'ref'   => 'o',
        ),
    );

    private $testAliasesFailure = array( 
        array(
            'short' => 'l',
            'long'  => 'lurking',
            'ref'   => 'x',
        ),
        array(
            'short' => 'e',
            'long'  => 'elvis',
            'ref'   => 'z',
        ),
        array(
            'short' => 'd',
            'long'  => 'destroy',
            'ref'   => 'd',
        ),
    );

    private $testArgsSuccess = array( 
        array(
            'foo.php',
            '-o',
            '"Test string2"',
            '--build',
            '42',
        ),
        array(
            'foo.php',
            '-b',
            '42',
            '--yank',
            '"a"',
            '--yank',
            '"b"',
            '--yank',
            '"c"',
        ),
        array(
            'foo.php',
            '--yank=a',
            '--yank=b',
            '--yank="c"',
            '-y',
            '1',
            '-y',
            '2'
        ),
        array(
            'foo.php',
            '--yank=a',
            '--yank=b',
            '-y',
            '1',
            'arg1',
            'arg2',
        ),
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleInputTest" );
	}

    protected function setUp()
    {
        $this->input = new ezcConsoleInput();
        foreach ( $this->testOptions as $paramData )
        {
            $this->input->registerOption( $this->createFakeOption( $paramData ) );
        }
    }

    protected function createFakeOption( $paramData )
    {
        $param = new ezcConsoleOption( $paramData['short'], $paramData['long'] );
        foreach ( $paramData['options'] as $name => $val )
        {
            if ( $name === 'depends' )
            {
                foreach ( $val as $dep )
                {
                    $param->addDependency( new ezcConsoleOptionRule( $this->input->getOption( $dep ) ) );
                }
                continue;
            }
            if ( $name === 'excludes' )
            {
                foreach ( $val as $dep )
                {
                    $param->addExclusion(new ezcConsoleOptionRule( $this->input->getOption( $dep ) ) );
                }
                continue;
            }
            $param->$name = $val;
        }
        return $param;
    }

    protected function tearDown()
    {
        unset( $this->input );
    }

    public function testRegisterOptionSuccess()
    {
        $input = new ezcConsoleInput();
        foreach ( $this->testOptions as $optionData )
        {
            $option = $this->createFakeOption( $optionData );
            $input->registerOption( $option );
            if ( $option->short !== '' )
            {
                $this->assertEquals( 
                    $option,
                    $input->getOption( $optionData['short'] ),
                    'Parameter not registered correctly with short name <' . $optionData['short'] . '>.'
                );
            }
            $this->assertEquals( 
                $option,
                $input->getOption( $optionData['long'] ),
                'Parameter not registered correctly with long name <' . $optionData['long'] . '>.'
            );
        }
    }

    public function testRegisterOptionFailure()
    {
        $input = new ezcConsoleInput();
        foreach ( $this->testOptions as $optionData )
        {
            $option = $this->createFakeOption( $optionData );
            $input->registerOption( $option );
        }
        foreach ( $this->testOptions as $optionData )
        {
            $option = $this->createFakeOption( $optionData );
            $exceptionThrown = false;
            try
            {
                $input->registerOption( $option );
            }
            catch ( ezcConsoleOptionAlreadyRegisteredException $e )
            {
                $exceptionThrown = true;
            }
            $this->assertTrue(
                $exceptionThrown,
                "Exception not thrown on double registered option " . $optionData["short"] === "" ? "determined by long name." : "determined by short name."
            );
        }
    }

    public function testUnregisterOptionSuccess()
    {
        // register aliases for testing
        $validParams = array();
        foreach ( $this->input->getOptions() as $param )
        {
            $validParams[$param->short] = $param;
        }
        foreach ( $this->testAliasesSuccess as $alias )
        {
            $this->input->registerAlias( $alias['short'], $alias['long'], $validParams[$alias['ref']]  );
        }

        // test itself
        foreach( $this->input->getOptions() as $option )
        {
            $this->input->unregisterOption( $option );
            $exceptionThrown = false;
            try
            {
                $this->input->getOption( isset( $option->short ) ? $option->short : $option->long );
            }
            catch( ezcConsoleOptionNotExistsException $e )
            {
                $exceptionThrown = true;
            }
            $this->assertTrue( $exceptionThrown, "Exception not unregistered correctly -{$option->short}/--{$option->long}." );
        }

        $this->assertEquals( 0, count( $this->input->getOptions() ) );
    }

    public function testUnregisterOptionFailure()
    {
        $option = new ezcConsoleOption( "x", "execute" );
        try
        {
            $this->input->unregisterOption( $option );
        }
        catch ( ezcConsoleOptionNotExistsException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on unregistering a non existent option." );
    }

    public function testFromStringSuccess()
    {
        $param = new ezcConsoleInput();
        $param->registerOptionString( '[a:|all:][u?|user?][i|info][o+test|overall+][d*|destroy*]' );
        $res['a'] = new ezcConsoleOption(
            'a', 
            'all', 
            ezcConsoleInput::TYPE_NONE, 
            NULL, 
            false, 
            'No help available.', 
            'Sorry, there is no help text available for this parameter.', 
            array(), 
            array (), 
            true 
        );
        $res['u'] = new ezcConsoleOption(
            'u',
            'user',
            ezcConsoleInput::TYPE_STRING,
            '',
            false,
            'No help available.',
            'Sorry, there is no help text available for this parameter.',
            array (),
            array (),
            true
        );
        $res['o'] = new ezcConsoleOption(
            'o',
            'overall',
            ezcConsoleInput::TYPE_STRING,
            'test',
            true,
            'No help available.',
            'Sorry, there is no help text available for this parameter.',
            array (),
            array (),
            true
        );
        $res['d'] = new ezcConsoleOption(
            'd',
            'destroy',
            ezcConsoleInput::TYPE_NONE,
            null,
            true,
            'No help available.',
            'Sorry, there is no help text available for this parameter.',
            array (),
            array (),
            true
        );
        $this->assertEquals( $res['a'], $param->getOption( 'a' ), 'Option -a not registered correctly.'  );
        $this->assertEquals( $res['u'], $param->getOption( 'u' ), 'Option -u not registered correctly.'  );
        $this->assertEquals( $res['o'], $param->getOption( 'o' ), 'Option -o not registered correctly.'  );
        $this->assertEquals( $res['d'], $param->getOption( 'd' ), 'Option -d not registered correctly.'  );
    }

    public function testFromStringFailure()
    {
        $param = new ezcConsoleInput();
        try
        {
            $param->registerOptionString( '[a:]' );
        }
        catch ( ezcConsoleOptionStringNotWellformedException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on not wellformed option string." );
    }

    /**
     * testRegisterAliasSuccess
     * 
     * @access public
     */
    public function testRegisterAliasSuccess()
    {
        $validParams = array();
        foreach ( $this->input->getOptions() as $param )
        {
            $validParams[$param->short] = $param;
        }
        foreach ( $this->testAliasesSuccess as $alias )
        {
            $this->input->registerAlias( $alias['short'], $alias['long'], $validParams[$alias['ref']]  );
            $this->assertTrue( $this->input->hasOption( $alias['short'] ), "Short name not available after alias registration." );
            $this->assertTrue( $this->input->hasOption( $alias['long'] ), "Long name not available after alias registration." );
        }
    }
    
    /**
     * testRegisterAliasFailure
     * 
     * @access public
     */
    public function testRegisterAliasFailure()
    {
        $refOption = new ezcConsoleOption( 'foo', 'bar' );
        foreach ( $this->testAliasesFailure as $alias )
        {
            $exceptionThrown = false;
            try 
            {
                $this->input->registerAlias( $alias['short'], $alias['long'], $refOption );
            }
            catch ( ezcConsoleOptionNotExistsException $e )
            {
                $exceptionThrown = true;
            }
            $this->assertTrue( $exceptionThrown, "Exception not thrown on regstering invalid alias --{$alias['short']}/--{$alias['long']}." );
        }
        foreach ( $this->testOptions as $option )
        {
            $exceptionThrown = false;
            try 
            {
                $this->input->registerAlias( $option['short'], $option['long'], $this->input->getOption( "t" ) );
            }
            catch ( ezcConsoleOptionAlreadyRegisteredException $e )
            {
                $exceptionThrown = true;
            }
            $this->assertTrue( $exceptionThrown, "Exception not thrown on regstering already existent option as alias --{$alias['short']}/--{$alias['long']}." );
        }
    }
    
    public function testUnregisterAliasSuccess()
    {
        // test preperation
        $validParams = array();
        foreach ( $this->input->getOptions() as $param )
        {
            $validParams[$param->short] = $param;
        }
        foreach ( $this->testAliasesSuccess as $alias )
        {
            $this->input->registerAlias( $alias['short'], $alias['long'], $validParams[$alias['ref']]  );
        }

        foreach ( $this->testAliasesSuccess as $alias )
        {
            $this->assertTrue( $this->input->hasOption( $alias['short'] ), "Alias incorrectly registered, cannot unregister." );
            $this->input->unregisterAlias( $alias['short'], $alias['long'] );
            $this->assertFalse( $this->input->hasOption( $alias['short'] ), "Alias incorrectly unregistered." );
        }
    }
    
    public function testUnregisterAliasFailure()
    {
        foreach ( $this->testOptions as $option )
        {
            $exceptionThrown = false;
            try
            {
                $this->input->unregisterAlias( !empty( $option['short'] ) ? $option['short'] : "f", $option['long'] );
            }
            catch ( ezcConsoleOptionNoAliasException $e )
            {
                $exceptionThrown = true;
            }
            $this->assertTrue( $exceptionThrown, "Exception not trown on try to unregister an option as an alias." );
        }
    }

    // Single parameter tests
    public function testProcessSuccessSingleShortNoValue()
    {
        $args = array(
            'foo.php',
            '-t',
        );
        $res = array( 
            't' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessSingleShortValue()
    {
        $args = array(
            'foo.php',
            '-o',
            'bar'
        );
        $res = array( 
            'o' => 'bar',
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessSingleLongNoValue()
    {
        $args = array(
            'foo.php',
            '--testing',
        );
        $res = array( 
            't' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessSingleLongValue()
    {
        $args = array(
            'foo.php',
            '--original',
            'bar'
        );
        $res = array( 
            'o' => 'bar',
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessFailureSingleShortDefault()
    {
        $args = array(
            'foo.php',
            '-b'
        );
        $res = array( 
            'b' => 42,
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMissingValueException' );
    }
    
    public function testProcessFailureSingleLongDefault()
    {
        $args = array(
            'foo.php',
            '--build'
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMissingValueException' );
    }
    
    public function testProcessSuccessFromArgv()
    {
        $_SERVER["argv"] = array(
            'foo.php',
            '--build',
            '42'
        );
        $this->input->process();
        $this->assertEquals(
            array( "b" => 42, "d" => "world" ),
            $this->input->getOptionValues(),
            "Processing from \$_SERVER['argv'] did not work."
        );
    }

    public function testProcessSuccessSingleShortNoValueArguments()
    {
        $args = array(
            'foo.php',
            '-s',
            '--',
            '-foo',
            '--bar',
            'baz',
        );
        $res = array( 
            's' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessSingleLongNoValueArguments()
    {
        $args = array(
            'foo.php',
            '--subway',
            '--',
            '-foo',
            '--bar',
            'baz',
        );
        $res = array( 
            's' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    // Multiple parameter tests
    public function testProcessSuccessMultipleShortNoValue()
    {
        $args = array(
            'foo.php',
            '-t',
            '-s',
        );
        $res = array( 
            't' => true,
            's' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMultipleShortValue()
    {
        $args = array(
            'foo.php',
            '-o',
            'bar',
            '-b',
            '23'
        );
        $res = array( 
            'o' => 'bar',
            'b' => 23,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMultipleLongNoValue()
    {
        $args = array(
            'foo.php',
            '--testing',
            '--subway',
        );
        $res = array( 
            't' => true,
            's' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMultipleLongValue()
    {
        $args = array(
            'foo.php',
            '--original',
            'bar',
            '--build',
            '23',
        );
        $res = array( 
            'o' => 'bar',
            'b' => 23,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMultipleLongValueWithEquals()
    {
        $args = array(
            'foo.php',
            '--original',
            'bar',
            '--build=23',
        );
        $res = array( 
            'o' => 'bar',
            'b' => 23,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessFailureMultipleShortDefault()
    {
        $args = array(
            'foo.php',
            '-b',
            '-d',
        );
        $res = array( 
            'b' => 42,
            'd' => 'world',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMissingValueException' );
    }

    public function testProcessFailureMultipleLongDefault()
    {
        $args = array(
            'foo.php',
            '--build',
            '--destroy',
        );
        $res = array( 
            'b' => 42,
            'd' => 'world',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMissingValueException' );
    }
    
    // Bug #8645: Default values not set correctly in ezcConsoleInput
    public function testProcessSuccessDefault()
    {
        $args = array(
            'foo.php',
        );
        $res = array( 
            'b' => 42,
            'd' => 'world',
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessSuccessMultipleLongSameNoValue()
    {
        $args = array(
            'foo.php',
            '--visual',
            '--visual',
        );
        $res = array( 
            'v' => array( true, true ),
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessSuccessArguments_1()
    {
        $args = array(
            'foo.php',
            '--original',
            'bar',
            '--build',
            '23',
            'argument',
            '1',
            '2',
        );
        $res = array( 
            0 => 'argument',
            1 => '1',
            2 => '2',
        );
        $this->argumentsProcessTestSuccess( $args, $res );
    }

    public function testProcessSuccessDependencies()
    {
        $args = array(
            'foo.php',
            '-t',
            '-o',
            'bar',
            '--build',
            23,
            '-y',
            'text',
            '--yank',
            'moretext',
            '-c'            // This one depends on -t, -o, -b and -y
        );
        $res = array( 
            't' => true,
            'o' => 'bar',
            'b' => 23,
            'y' => array( 
                'text',
                'moretext'
            ),
            'c' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessExclusions()
    {
        $args = array(
            'foo.php',
            '-o',
            'bar',
            '--build',
            23,
            '--edit'            // This one exclude -t and -y
        );
        $res = array( 
            'o' => 'bar',
            'b' => 23,
            'e' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessSuccessDependenciesExclusions()
    {
        $args = array(
            'foo.php',
            '-t',
            '-o',
            'bar',
            '-n'            // This one depends on -t and -o, but excludes -b and -y
        );
        $res = array( 
            't' => true,
            'o' => 'bar',
            'n' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessSuccessDependencieValues()
    {
        $rule = new ezcConsoleOptionRule( $this->input->getOption( "y" ), array( "foo", "bar" ) );
        $option = new ezcConsoleOption( "x", "execute" );
        $option->addDependency( $rule );
        $this->input->registerOption( $option );

        $args = array(
            'foo.php',
            '-x',
            '-y',
            'bar',
        );

        $res = array(
            'x' => true,
            'y' => array( 'bar' ),
        );

        $this->commonProcessTestSuccess( $args, $res );
    }
    

    public function testProcessSuccessExclusionValues()
    {
        $rule = new ezcConsoleOptionRule( $this->input->getOption( "y" ), array( "foo", "bar" ) );
        $option = new ezcConsoleOption( "x", "execute" );
        $option->addExclusion( $rule );
        $this->input->registerOption( $option );

        $args = array(
            'foo.php',
            '-x',
            '-y',
            'baz',
        );

        $res = array(
            'x' => true,
            'y' => array( 'baz' ),
        );

        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMandatory()
    {
        $args = array(
            'foo.php',
            '-q',
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'q',
                    'long'      => 'quite',
                    'options'   => array(
                        'mandatory' => true,
                    ),
                )
            )
        );
        $res = array( 
            'q' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessMandatoryDefault()
    {
        $args = array(
            'foo.php',
            '-q',
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'q',
                    'long'      => 'quite',
                    'options'   => array(
                        'default'   => 'test',
                        'mandatory' => true,
                    ),
                )
            )
        );
        $res = array( 
            'q' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessSuccessHelp()
    {
        $args = array(
            'foo.php',
            '-h',
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'q',
                    'long'      => 'quite',
                    'options'   => array(
                        'mandatory' => true,
                    ),
                )
            )
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'h',
                    'long'      => 'help',
                    'options'   => array(
                        'isHelpOption' => true,
                    ),
                )
            )
        );
        $res = array( 
            'h' => true,
        );
        $this->commonProcessTestSuccess( $args, $res );
    }

    public function testProcessFailureExistance_1()
    {
        $args = array(
            'foo.php',
            '-q',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionNotExistsException' );
    }
    
    public function testProcessFailureExistance_2()
    {
        $args = array(
            'foo.php',
            '-tools',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionNotExistsException' );
    }
    
    public function testProcessFailureExistance_3()
    {
        $args = array(
            'foo.php',
            '-testingaeiou',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionNotExistsException' );
    }
    
    public function testProcessFailureTypeInt()
    {
        $args = array(
            'foo.php',
            '-b',
            'not_an_int'
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionTypeViolationException' );
    }
    
    // Bug #9046: New bug: [ConsoleTools] Last argument not treated invalid option value
    public function testProcessNoFailureTypeNone()
    {
        $args = array(
            'foo.php',
            '-s',
            'a_parameter'
        );
        $res = array( "s" => true );
        $this->commonProcessTestSuccess( $args, $res );
    }
    
    public function testProcessFailureTypeNone()
    {
        $args = array(
            'foo.php',
            '-s',
            'a_parameter',
            'another_parameter'
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionTypeViolationException' );
    }
    
    public function testProcessFailureNovalue()
    {
        $args = array(
            'foo.php',
            '-o',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMissingValueException' );
    }
    
    public function testProcessFailureMultiple()
    {
        $args = array(
            'foo.php',
            '-d',
            'mars',
            '--destroy',
            'venus',
            
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionTooManyValuesException' );
    }
    
    public function testProcessFailureDependencies()
    {
        $args = array(
            'foo.php',
            '-t',
//            '-o',
//            'bar',
            '--build',
            23,
            '-y',
            'text',
            '--yank',
            'moretext',
            '-c'            // This one depends on -t, -o, -b and -y
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionDependencyViolationException' );
    }

    public function testProcessFailureDependencieValues()
    {
        $rule = new ezcConsoleOptionRule( $this->input->getOption( "y" ), array( "foo", "bar" ) );
        $option = new ezcConsoleOption( "x", "execute" );
        $option->addDependency( $rule );
        $this->input->registerOption( $option );

        $args = array(
            'foo.php',
            '-y',
            'baz',
            '-x',
        );

        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionDependencyViolationException' );
    }
    
    public function testProcessFailureExclusions()
    {
        $args = array(
            'foo.php',
            '-t',
            '-o',
            'bar',
            '--build',
            23,
            '--edit'            // This one excludes -t and -y
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionExclusionViolationException' );
    }

    public function testProcessFailureExclusionValues()
    {
        $rule = new ezcConsoleOptionRule( $this->input->getOption( "y" ), array( "foo", "bar" ) );
        $option = new ezcConsoleOption( "x", "execute" );
        $option->addExclusion( $rule );
        $this->input->registerOption( $option );

        $args = array(
            'foo.php',
            '-y',
            'bar',
            '-x',
        );

        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionExclusionViolationException' );
    }
    
    public function testProcessFailureArguments()
    {
        $args = array(
            'foo.php',
            '-t',
            '--visual',         // This one forbids arguments
            '-o',
            'bar',
            'someargument',
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionArgumentsViolationException' );
    }
    
    public function testProcessFailureMandatory()
    {
        $args = array(
            'foo.php',
            '-s',
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'q',
                    'long'      => 'quite',
                    'options'   => array(
                        'mandatory' => true,
                    ),
                )
            )
        );
        $this->commonProcessTestFailure( $args, 'ezcConsoleOptionMandatoryViolationException' );
    }

    public function testGetHelp1()
    {
        $res = array( 
            array( 
                '-t / --testing',
                'No help available.',
            ),
            array( 
                '-s / --subway',
                'No help available.',
            ),
            array( 
                '--carry',
                'No help available.',
            ),
            array( 
                '-v / --visual',
                'No help available.',
            ),
            array( 
                '-o / --original',
                'No help available.',
            ),
            array( 
                '-b / --build',
                'No help available.',
            ),
            array( 
                '-d / --destroy',
                'No help available.',
            ),
            array( 
                '-y / --yank',
                'Some stupid short text.',
            ),
            array( 
                '-c / --console',
                'Some stupid short text.',
            ),
            array( 
                '-e / --edit',
                'No help available.',
            ),
            array( 
                '-n / --new',
                'No help available.',
            ),
        );
        $this->assertEquals( 
            $res,
            $this->input->getHelp(),
            'Help array was not generated correctly.'
        );
    }
    
    public function testGetHelp2()
    {
        $res = array( 
            array( 
                '-t / --testing',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-s / --subway',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '--carry',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-v / --visual',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-o / --original',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-b / --build',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-d / --destroy',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-y / --yank',
                'Some even more stupid, but somewhat longer long describtion.',
            ),
            array( 
                '-c / --console',
                'Some even more stupid, but somewhat longer long describtion.',
            ),
            array( 
                '-e / --edit',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-n / --new',
                'Sorry, there is no help text available for this parameter.',
            ),
        );
        $this->assertEquals( 
            $res,
            $this->input->getHelp( true ),
            'Help array was not generated correctly.'
        );
        
    }
    
    public function testGetHelp3()
    {
        $res = array( 
            array( 
                '-t / --testing',
                'No help available.',
            ),
            array( 
                '-s / --subway',
                'No help available.',
            ),
            array( 
                '-v / --visual',
                'No help available.',
            ),
        );
        $this->assertEquals( 
            $res,
            $this->input->getHelp(false, array( 't', 's', 'v' ) ),
            'Help array was not generated correctly.'
        );
    }
    
    public function testGetHelp4()
    {
        $res = array( 
            array( 
                '-t / --testing',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-s / --subway',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-y / --yank',
                'Some even more stupid, but somewhat longer long describtion.',
            ),
            array( 
                '-e / --edit',
                'Sorry, there is no help text available for this parameter.',
            ),
            array( 
                '-n / --new',
                'Sorry, there is no help text available for this parameter.',
            ),
        );
        $this->assertEquals( 
            $res,
            $this->input->getHelp( true, array( 't', 'subway', 'yank', 'e', 'n' ) ),
            'Help array was not generated correctly.'
        );
        
    }
    
    public function testGetSynopsis()
    {
        $this->assertEquals( 
            '$ '.$_SERVER['argv'][0].' [-t] [-s] [--carry] [-v] [-o <string>] [-b 42] [-d "world"] [-y <string>] [-c] [-e] [-n]  [[--] <args>]',
            $this->input->getSynopsis(),
            'Program synopsis not generated correctly.'
        );
    }
    
    public function testGetHelpTable()
    {
        $output = new ezcConsoleOutput();
        
        $res = new ezcConsoleTable( $output, 80 ); 
        $res[0][0]->content = '-t / --testing';
        $res[0][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $res[1][0]->content = '-s / --subway';
        $res[1][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $res[2][0]->content = '-y / --yank';
        $res[2][1]->content = 'Some even more stupid, but somewhat longer long describtion.';
                
        $res[3][0]->content = '-e / --edit';
        $res[3][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $table = new ezcConsoleTable( $output, 80 );
        $table = $this->input->getHelpTable( $table, true, array( 't', 'subway', 'yank', 'e' ) );
        $this->assertEquals(
            $res,
            $table,
            'Help table not generated correctly.'
        );
    }

    public function testGetHelpTableDefaultParameters()
    {
        $output = new ezcConsoleOutput();
        
        $res = new ezcConsoleTable( $output, 80 ); 
        $res[0][0]->content = '-t / --testing';
        $res[0][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $res[1][0]->content = '-s / --subway';
        $res[1][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $res[2][0]->content = '-y / --yank';
        $res[2][1]->content = 'Some even more stupid, but somewhat longer long describtion.';
                
        $res[3][0]->content = '-e / --edit';
        $res[3][1]->content = 'Sorry, there is no help text available for this parameter.';
                
        $table = new ezcConsoleTable( $output, 80 );
        $table = $this->input->getHelpTable( $table );

        $this->assertEquals( 11, sizeof( $table ), "Expected 11 elements in the generated HelpTable" );
    }



    public function testGetHelpText()
    {
        $res = <<<EOF
Usage: $ {$_SERVER['argv'][0]} [-y <string>] [-e]  [[--] <args>]
Lala

-y / --yank  Some
             even
             more
             stupid,
             but
             somewhat
             longer
             long
             describtion.
-e / --edit  Sorry,
             there
             is no
             help
             text
             available
             for
             this
             parameter.

EOF;
        $this->assertEquals(
            $res,
            $this->input->getHelpText( 'Lala', 20, true, array( 'e', 'y' ) ),
            'Help text not generated correctly.'
        );
    }
    
    public function testGetSynopsis1()
    {
        $this->assertEquals( 
            '$ '.$_SERVER['argv'][0].' [-t] [-s] [-o <string>]  [[--] <args>]',
            $this->input->getSynopsis( array( 't', 's', 'o' ) ),
            'Program synopsis not generated correctly.'
        );
    }
    
    /**
     * Tests bug #7923. 
     * 
     * @return void
     */
    public function testGetSynopsis2()
    {
        $this->assertEquals( 
            '$ '.$_SERVER['argv'][0].' [-t] [-s] [-v]  [[--] <args>]',
            $this->input->getSynopsis( array( 't', 's', 'v' ) ),
            'Program synopsis not generated correctly.'
        );
    }
    
    public function testGetSynopsis3()
    {
        $this->assertEquals( 
            '$ ' . $_SERVER['argv'][0] . ' [-s] [-b 42]  [[--] <args>]',
            $this->input->getSynopsis( array( 'b', 's' ) ),
            'Program synopsis not generated correctly.'
        );
    }
    
    public function testGetSynopsis4()
    {
        $this->input->registerOption(
            new ezcConsoleOption(
                "x",
                "execute",
                ezcConsoleInput::TYPE_INT
            )
        );
        $this->assertEquals( 
            '$ ' . $_SERVER['argv'][0] . ' [-s] [-x <int>]  [[--] <args>]',
            $this->input->getSynopsis( array( 'x', 's' ) ),
            'Program synopsis not generated correctly.'
        );
    }

    public function testHelpOptionSet()
    {
        $args = array(
            'foo.php',
            '-h',
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'q',
                    'long'      => 'quite',
                    'options'   => array(
                        'mandatory' => true,
                    ),
                )
            )
        );
        $this->input->registerOption(
            $this->createFakeOption(
                array( 
                    'short'     => 'h',
                    'long'      => 'help',
                    'options'   => array(
                        'isHelpOption' => true,
                    ),
                )
            )
        );
        $res = array( 
            'h' => true,
        );

        $this->assertFalse( $this->input->helpOptionSet(), "Help option seems to be set, algthough nothing was processed." );
        $this->commonProcessTestSuccess( $args, $res );
        $this->assertTrue( $this->input->helpOptionSet(), "Help option seems not to be set, algthough it was." );
    }
    
    private function commonProcessTestSuccess( $args, $res )
    {
        $this->input->process( $args );
        $values = $this->input->getOptionValues();
        $this->assertTrue( count( array_diff( $res, $values ) ) == 0, 'Parameters processed incorrectly.' );
    }
    
    private function commonProcessTestFailure( $args, $exceptionClass )
    {
        try 
        {
            $this->input->process( $args );
        }
        catch ( ezcConsoleException $e )
        {
            $this->assertSame(
                $exceptionClass,
                get_class( $e ),
                'Wrong exception thrown for invalid parameter submission. Expected class <'.$exceptionClass.'>, received <'.get_class( $e ).'>'
            );
            return;
        }
        $this->fail( 'Exception not thrown for invalid parameter submition.' );
    }

    private function argumentsProcessTestSuccess( $args, $res )
    {
        $this->input->process( $args );
        $this->assertEquals(
            $res,
            $this->input->getArguments(),
            'Arguments not parsed correctly.'
        );
    }
}
?>
