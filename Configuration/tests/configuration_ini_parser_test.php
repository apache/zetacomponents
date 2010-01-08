<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationIniParserTest extends ezcTestCase
{
    public function testNonExistingFile()
    {
        try
        {
            $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/not-here.ini' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file 'Configuration/tests/files/not-here.ini' could not be found.", $e->getMessage() );
        }
    }

    public function testIterator1()
    {
        $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/one-group.ini' );
        try
        {
            foreach ( $parser as $item )
            {
            }
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( Exception $e )
        {
            $this->assertEquals( 'You can only use this implementation of the iterator with a NoRewindIterator.', $e->getMessage() );
        }
    }

    public function testIterator2()
    {
        $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/multi-dim2.ini' );
        foreach ( new NoRewindIterator( $parser ) as $key => $item )
        {
            $this->assertSame( 0, $key );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcConfigurationIniParserTest' );
    }

}
?>
