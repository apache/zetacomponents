<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once 'data/testclasses.php';

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveOptionsTest extends ezcTestCase
{
    public function testReadOnly()
    {
        $options = new ezcArchiveOptions;
        $options->readOnly = true;
        self::assertTrue( $options->readOnly );
        $options->readOnly = false;
        self::assertFalse( $options->readOnly );
    }

    public function testReadOnlyWrong()
    {
        try
        {
            $options = new ezcArchiveOptions;
            $options->readOnly = null;
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '' that you were trying to assign to setting 'readOnly' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testCallback()
    {
        $options = new ezcArchiveOptions;
        $options->extractCallback = null;
        self::assertNull( $options->extractCallback );

        $options->extractCallback = new testExtractCallback;
        self::assertType( 'ezcArchiveCallback', $options->extractCallback );
    }

    public function testCallbackWrong()
    {
        try
        {
            $options = new ezcArchiveOptions;
            $options->extractCallback = "foobar";
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'foobar' that you were trying to assign to setting 'extractCallback' is invalid. Allowed values are: instance of ezcArchiveCallback.", $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
