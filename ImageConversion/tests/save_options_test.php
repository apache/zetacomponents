<?php
/**
 * ezcImageSaveOptionsTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcImageConversionSaveOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testGetAccessSuccess()
    {
        $opt = new ezcImageSaveOptions();

        $this->assertNull( $opt->compression );
        $this->assertNull( $opt->quality );
        $this->assertNull( $opt->transparencyReplacementColor );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcImageSaveOptions();
        
        try
        {
            echo $opt->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on get access to invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcImageSaveOptions();

        $this->assertSetProperty(
            $opt,
            'compression',
            range( 0, 9, 1 )
        );
        $this->assertSetProperty(
            $opt,
            'quality',
            range( 0, 100, 10 )
        );
        $this->assertSetProperty(
            $opt,
            'transparencyReplacementColor',
            array(
                array( 23, 42, 13 ),
                array( 0, 0, 0 ),
            )
        );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcImageSaveOptions();

        $this->assertSetPropertyFails(
            $opt,
            'compression',
            array( true, false, 23.42, 'foo', array(), new stdClass(), -1, 10, -23 )
        );
        $this->assertSetPropertyFails(
            $opt,
            'quality',
            array( true, false, 23.42, 'foo', array(), new stdClass(), -1, 101, -23 )
        );
        $this->assertSetPropertyFails(
            $opt,
            'transparencyReplacementColor',
            array(
                true, false, 23.42, 'foo', array(), new stdClass(), -1, 101,
                array( 42, 23 ), array( 'foo' => 42, 'bar' => 23 ),
                array( 1 => 0, 2 => 0, 3 => 0 ), array( 'foo' => 'bar' )
            )
        );

        try
        {
            $opt->foo = 23;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on set access to invalid property foo." );
    }
}

?>
