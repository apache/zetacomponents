<?php
/**
 * ezcConsoleOutputTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleTable class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleTableTest extends ezcTestCase
{
    private $tableData1 = array( 
        array( 'Heading no. 1', 'Longer heading no. 2', 'Head 3' ),
        array( 'Data cell 1', 'Data cell 2', 'Data cell 3' ),
        array( 'Long long data cell with even more text in it...', 'Data cell 4', 'Data cell 5' ),
        array( 'a b c d e f g h i j k l m n o p q r s t u v w x ', 'Data cell', 'Data cell' ),
    );

    private $tableData2 = array( 
        array( 'a', 'b', 'c', 'd', 'e', 'f' ),
        array( 'g', 'h', 'i', 'j', 'k', 'l' ),
    );

    private $tableData3 = array( 
        array( 'Parameter', 'Shortcut', 'Descrition' ),
        array( 'Append text to a file. This parameter takes a string value and may be used multiple times.', '--append', '-a' ),
        array( 'Prepend text to a file. This parameter takes a string value and may be used multiple times.', '--prepend', '-p' ),
        array( 'Forces the action desired without paying attention to any errors.', '--force', '-f' ),
        array( 'Silence all kinds of warnings issued by this program.', '--silent', '-s' ),
    );
    
    private $tableData4 = array( 
        array( 'Some very very long data here.... and it becomes even much much longer... and even longer....', 'Short', 'Some very very long data here.... and it becomes even much much longer... and even longer....', 'Short' ),
        array( 'Short', "Some very very long data here....\n\nand it becomes even much much longer...\n\nand even longer....", 'Short', 'Some very very long data here.... and it becomes even much much longer... and even longer....' ),
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleTableTest" );
	}

    protected function setUp()
    {
        $this->output = new ezcConsoleOutput();
        $formats = array(
            'red' => array( 
                'color' => 'red',
                'style' => 'bold'
            ),
            'blue' => array( 
                'color' => 'blue',
                'style' => 'bold'
            ),
            'green' => array( 
                'color' => 'green',
                'style' => 'bold'
            ),
            'magenta' => array( 
                'color' => 'magenta',
                'style' => 'bold'
            ),
        );
        foreach ( $formats as $name => $format )
        {
            foreach ( $format as $type => $val )
            {
                $this->output->formats->$name->$type = $val;
            }
        }
    }

    public function testTable1a()
    {
        $this->commonTableTest(
            __FUNCTION__, 
            $this->tableData1,
            array( 'cols' => count( $this->tableData1[0] ), 'width' => 80 ),
            array( 'lineFormatHead' => 'green' ),
            array( 0 )
        );
    }
    
    public function testTable1b()
    {
        $this->commonTableTest(
            __FUNCTION__, 
            $this->tableData1,
            array( 'cols' => count( $this->tableData1[0] ), 'width' => 40 ),
            array( 'lineFormatHead' => 'red',  ),
            array( 0 )
        );
    }
    
    public function testTable2a()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData2,
            array( 'cols' => count( $this->tableData2[0] ), 'width' =>  60 ),
            array( 'lineFormatHead' => 'magenta', 'defaultAlign' => ezcConsoleTable::ALIGN_RIGHT, 'widthType' => ezcConsoleTable::WIDTH_FIXED )
        );
    }
    
    public function testTable2b()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData2,
            array( 'cols' => count( $this->tableData2[0] ), 'width' =>  60 ),
            array( 'lineFormatHead' => 'magenta', 'defaultAlign' => ezcConsoleTable::ALIGN_RIGHT )
        );
    }
   
    // Bug #8738: Unexpected behaviour with options->colPadding
    public function testTableColPadding1()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData2,
            array( 'width' =>  100 ),
            array( 'defaultAlign' => ezcConsoleTable::ALIGN_CENTER, 'colPadding' => '~~~', 'widthType' => ezcConsoleTable::WIDTH_FIXED )
        );
    }
    
    // Bug #8738: Unexpected behaviour with options->colPadding
    public function testTableColPadding2()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData2,
            array( 'width' =>  100 ),
            array( 'defaultAlign' => ezcConsoleTable::ALIGN_CENTER, 'colPadding' => '~~~' )
        );
    }
    
    public function testTable3a()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData3,
            array( 'cols' => count( $this->tableData3[0] ), 'width' =>  120 ),
            array( 'lineFormatHead' => 'blue', 'defaultAlign' => ezcConsoleTable::ALIGN_CENTER, 'lineVertical' => '#', 'lineHorizontal' => '#', 'corner' => '#' ),
            array( 0, 3 )
        );
    }
    
    public function testTable3b()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData3,
            array( 'cols' => count( $this->tableData3[0] ), 'width' =>  80 ),
            array( 'lineFormatHead' => 'magenta', 'lineVertical' => 'v', 'lineHorizontal' => 'h', 'corner' => 'c' ),
            array( 1, 2 )
        );
    }
     
    public function testTable4a()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData4,
            array( 'cols' => count( $this->tableData4[0] ), 'width' =>  120 ),
            array( 'lineFormatHead' => 'blue', 'defaultAlign' => ezcConsoleTable::ALIGN_CENTER, 'colWrap' => ezcConsoleTable::WRAP_CUT ),
            array( 0 )
        );
    }
    
    public function testTable4b()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData4,
            array( 'cols' => count( $this->tableData4[0] ), 'width' =>  120 ),
            array( 'lineFormatHead' => 'blue', 'defaultAlign' => ezcConsoleTable::ALIGN_LEFT, 'colWrap' => ezcConsoleTable::WRAP_AUTO ),
            array( 0 )
        );
    }
    
    public function testTable4c()
    {
        $this->commonTableTest(
            __FUNCTION__,
            $this->tableData4,
            array( 'cols' => count( $this->tableData4[0] ), 'width' =>  120 ),
            array( 'lineFormatHead' => 'blue', 'defaultAlign' => ezcConsoleTable::ALIGN_CENTER, 'colWrap' => ezcConsoleTable::WRAP_CUT ),
            array( 0 )
        );
    }
    
    public function testTableConfigurationFailure1 ()
    {
        // Missing 'cols' setting
        try
        {
            $table = new ezcConsoleTable( $this->output, null );
        }
        catch (ezcBaseValueException $e)
        {
            $this->assertTrue( 
                true,
                'Wrong exception code thrown on missing <cols> setting.'
            );
            return;
        }
        $this->fail( 'No or wrong exception thrown on missing <cols> setting.' );
    }
    
    public function testTableConfigurationFailure2 ()
    {
        // 'cols' setting wrong type
        try
        {
            $table = new ezcConsoleTable( $this->output, 'test' );
        }
        catch (ezcBaseValueException $e)
        {
            $this->assertTrue( 
                true,
                'Wrong exception code thrown on missing <cols> setting.'
            );
            return;
        }
        $this->fail( 'No or wrong exception thrown on wrong type for <cols> setting.' );
    }

    public function testTableConfigurationFailure3 ()
    {
        // 'cols' setting out of range
        try
        {
            $table = new ezcConsoleTable( $this->output, -10 );
        }
        catch (ezcBaseValueException $e)
        {
            $this->assertTrue( 
                true,
                'Wrong exception code thrown on missing <cols> setting.'
            );
            return;
        }
        $this->fail( 'No or wrong exception thrown on invalid value of <cols> setting.' );
    }

    public function testArrayAccess()
    {
        $table = new ezcConsoleTable( $this->output, 100 );
        $table[0];
    }

    public function testSetOptions_Success1()
    {
        $out = new ezcConsoleOutput();
        $table = new ezcConsoleTable( $out, 100 );
        try
        {
            $table->options->colWidth = array( 1, 2, 3 );
            $table->options->colWrap = ezcConsoleTable::WRAP_CUT;
            $table->options->defaultAlign = ezcConsoleTable::ALIGN_CENTER;
            $table->options->colPadding = ':';
            $table->options->widthType = ezcConsoleTable::WIDTH_FIXED;
            $table->options->lineVertical = ':';
            $table->options->lineHorizontal = '-';
            $table->options->corner = 'o';
            $table->options->defaultFormat = 'test';
            $table->options->defaultBorderFormat = 'test2';
        }
        catch ( Exception $e )
        {
            $this->fail( "Exception while setting valid option: {$e->getMessage()}." );
        }
    }
    
    public function testSetOptions_Success2()
    {
        try
        {
            $opt = new ezcConsoleTableOptions(
                array( 1, 2, 3 ),
                ezcConsoleTable::WRAP_CUT,
                ezcConsoleTable::ALIGN_CENTER,
                ':',
                ezcConsoleTable::WIDTH_FIXED,
                ':',
                '-',
                'o',
                'test',
                'test2'
            );
        }
        catch ( Exception $e )
        {
            $this->fail( "Exception while setting valid option: {$e->getMessage()}." );
        }
    }

    public function testSetOptions_Success3()
    {
        try
        {
            $opt = new ezcConsoleTableOptions(
                array(
                    "colWidth" => array( 1, 2, 3 ),
                    "colWrap" => ezcConsoleTable::WRAP_CUT,
                    "defaultAlign" => ezcConsoleTable::ALIGN_CENTER,
                    "colPadding" => ':',
                    "widthType" => ezcConsoleTable::WIDTH_FIXED,
                    "lineVertical" => ':',
                    "lineHorizontal" => '-',
                    "corner" => 'o',
                    "defaultFormat" => 'test',
                    "defaultBorderFormat" => 'test2'
                )
            );
        }
        catch ( Exception $e )
        {
            $this->fail( "Exception while setting valid option: {$e->getMessage()}." );
        }
    }

    public function testSetOptions_Failure()
    {
        $out = new ezcConsoleOutput();
        $table = new ezcConsoleTable( $out, 100 );
    
        $exceptionThrown = false;
        
        try
        {
            $table->options->colWidth = 'test';
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <colWidth>.');
        }
        $exceptionThrown = false;

        try
        {
            $table->options->colWrap = 100;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <colWrap>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->defaultAlign = 101;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <defaultAlign>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->colPadding = 102;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <colPadding>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->widthType = 103;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <widthType>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->lineVertical = 104;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <lineVertical>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->lineHorizontal = 105;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <lineHorizontal>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->corner = 106;
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <corner>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->defaultFormat = array();
        } 
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <defaultFormat>.');
        }
        $exceptionThrown = false;
        
        try
        {
            $table->options->defaultBorderFormat = true;
        }
        catch ( ezcBaseValueException $e)
        {
            $exceptionThrown = true;
        }
        if ( !$exceptionThrown )
        {
            $this->fail( 'No exception thrown on invalid setting for <defaultBorderFormat>.');
        }
        $exceptionThrown = false;
        
    }
    
    private function commonTableTest( $refFile, $tableData, $settings, $options, $headrows = array() )
    {
        $table =  new ezcConsoleTable( 
            $this->output,
            $settings['width']
        );
        
        // Set options
        foreach ( $options as $key => $val )
        {
            if ( $key == 'lineFormatHead' )
            {
                continue;
            }
            $table->options->$key = $val;
        }

        // Add data
        for ( $i = 0; $i < count( $tableData ); $i++ )
        {
            for ( $j = 0; $j < count( $tableData[$i]); $j++ )
            {
                $table[$i][$j]->content = $tableData[$i][$j];
            }
        }
        
        // Set a specific cell format
        $table[0][0]->format = 'red';

        // Apply head format to head rows
        foreach ( $headrows as $row )
        {
            $table[$row]->borderFormat = isset( $options['lineFormatHead'] ) ? $options['lineFormatHead'] : 'default';
        }
        
        // For visual inspection, uncomment this block
//        echo "\n\n";
//        echo "Old $refFile:\n:";
//        echo file_get_contents( dirname( __FILE__ ) . '/data/' . $refFile . '.dat' );
//        echo "New $refFile:\n:";
//        echo implode( "\n", $table->getTable() );
//        echo "\n\n";
        
        $refFile = dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . $refFile . '.dat';
        // To prepare test files, uncomment this block
        //file_put_contents( $refFile, implode( PHP_EOL, $table->getTable() ) );
        
        // For test assertion, uncomment this block
        $this->assertEquals(
            file_get_contents( $refFile ),
            implode( PHP_EOL, $table->getTable() ),
            'Table not correctly generated for ' . $refFile . '.'
        );

    }
}
?>
