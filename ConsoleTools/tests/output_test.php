<?php
/**
 * ezcConsoleToolsOutputTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutput class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsOutputTest extends ezcTestCase
{
    /**
     * testString 
     * 
     * @var string
     */
    private $testString = 'A passion for php';

    private $testFormats = array(
        'color_only_1' => array(
            'in'  => array( 
                'color' => 'blue',
            ),
            'out' => "\033[34m%s\033[0m"
        ),
        'color_only_2' => array( 
            'in'  => array( 
                'color' => 'red',
            ),
            'out' => "\033[31m%s\033[0m"
        ),
        'bgcolor_only_1' => array( 
            'in'  => array( 
                'bgcolor' => 'green',
            ),
            'out' => "\033[42m%s\033[0m"
        ),
        'bgcolor_only_2' => array( 
            'in'  => array( 
                'bgcolor' => 'yellow',
            ),
            'out' => "\033[43m%s\033[0m"
        ),
        'style_only_1' => array( 
            'in'  => array( 
                'style' => 'bold',
            ),
            'out' => "\033[1m%s\033[0m"
        ),
        'style_only_2' => array( 
            'in'  => array( 
                'style' => 'negative',
            ),
            'out' => "\033[7m%s\033[0m"
        ),
    );

    private $testOptions = array( 
        'set_1' => array( 
            'verboseLevel'      => 1,
        ),
        'set_2' => array( 
            'verboseLevel'      => 5,
            'autobreak'         => 20,
            'useFormats'        => false,
        ),
        'set_3' => array( 
            'autobreak'         => 5,
            'useFormats'        => true,
            'format'            => array( 
                'color' => 'blue',
                'bgcolor' => 'green',
                'style' => 'negative',
            ),
        ),
    );

    /**
     * consoleOutput 
     * 
     * @var mixed
     */
    private $consoleOutput;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsOutputTest" );
	}

    protected function setUp()
    {
        $this->consoleOutput = new ezcConsoleOutput();
        foreach ( $this->testFormats as $name => $inout ) 
        {
            foreach ( $inout['in'] as $formatName => $val )
            {
                $this->consoleOutput->formats->$name->$formatName = $val;
            }
        }
    }

    protected function tearDown()
    {
        unset( $this->consoleOutput );
    }

    /**
     * testFormatText
     * 
     * @access public
     */
    public function testFormatText()
    {
        foreach ( $this->testFormats as $name => $inout ) 
        {
            $realRes = $this->consoleOutput->formatText( $this->testString, $name );
            $fakeRes = ezcBaseFeatures::os() !== "Windows" ? sprintf( $inout['out'], $this->testString ) : $this->testString;
            $this->assertEquals( 
                $realRes,
                $fakeRes, 
                "Test <{$name}> failed. String <{$realRes}> (real) is not equal to <{$fakeRes}> (fake)."
            );
        }
    }

    /**
     * testOutputText
     * 
     * @access public
     */
    public function testOutputText()
    {
        foreach ( $this->testFormats as $name => $inout ) 
        {
            ob_start();
            $this->consoleOutput->outputText( $this->testString, $name );
            $realRes = ob_get_contents();
            ob_end_clean();
            $fakeRes = ezcBaseFeatures::os() !== "Windows" ? sprintf( $inout['out'], $this->testString ) : $this->testString;
            $this->assertEquals( 
                $fakeRes, 
                $realRes,
                "Test <{$name}> failed. String <{$realRes}> (real) is not equal to <{$fakeRes}> (fake)."
            );
        }
    }

    /**
     * testOutputTextAutobreak
     * 
     * @access public
     */
    public function testOutputTextAutobreak()
    {
        $this->consoleOutput->options->autobreak = 20;
        $testText = 'Some text which is obviously longer than 20 characters and should be broken.';

        $testResText = <<<EOT
Some text which is
obviously longer
than 20 characters
and should be
broken.
EOT;
        
        foreach ( $this->testFormats as $name => $inout ) 
        {
            ob_start();
            $this->consoleOutput->outputText( $testText, $name );
            $realRes = ob_get_contents();
            ob_end_clean();
            
            $fakeRes = ezcBaseFeatures::os() !== "Windows" ? sprintf( $inout['out'], $testResText ) : $testResText;
            $this->assertEquals( 
                $fakeRes, 
                $realRes, 
                'Test "' . $name . ' failed. String <' . $realRes . '> (real) is not equal to <' . $fakeRes . '> (fake).' 
            );
        }
    }

    public function testOutputColorAliases()
    {
        $this->consoleOutput->formats->aliasBG->bgcolor = "gray";
        $this->consoleOutput->formats->aliasBG->color = "white";
        $this->consoleOutput->formats->realBG->bgcolor = "black";
        $this->consoleOutput->formats->realBG->color = "white";
        
        $this->consoleOutput->formats->realFG->color = "gray";
        $this->consoleOutput->formats->realFG->bgcolor = "white";
        $this->consoleOutput->formats->aliasFG->color = "black";
        $this->consoleOutput->formats->aliasFG->bgcolor = "white";

        $this->assertEquals(
            $this->consoleOutput->formatText( "I am black!", "aliasBG" ),
            $this->consoleOutput->formatText( "I am black!", "realBG" ),
            "Backgroundcolor <gray> not correctly aliased to <black>."
        );

        $this->assertEquals(
            $this->consoleOutput->formatText( "I am gray!", "aliasFG" ),
            $this->consoleOutput->formatText( "I am gray!", "realFG" ),
            "Foregroundcolor <black> not correctly aliased to <gray>."
        );
    }

    public function testOutputToTarget()
    {
        $outFile = $this->createTempDir( __FUNCTION__ ) . "/outfile";
        touch( $outFile );
        $this->consoleOutput->formats->targetFile->target = $outFile;
        $this->consoleOutput->formats->targetFile->color = "blue";
        $this->consoleOutput->outputText( "Hello, I'm a cool text, written to a file!", "targetFile" );

        $this->assertEquals( 
            $this->consoleOutput->formatText( "Hello, I'm a cool text, written to a file!", "targetFile" ),
            file_get_contents( $outFile )
        );
    }

    /**
     * dumpString 
     * 
     * @param mixed $string 
     */
    private function dumpString( $string )
    {
        echo 'Dumping string of length ' . strlen( $string ) . ":\n\n";
        for ( $i = 0; $i < strlen( $string ); $i++ )
        {
            echo "<{$string[$i]}> = -" . ord( $string[$i] ) . "-\n";
        }
        echo "Finished dumping string.\n\n";
    }
}
?>
