<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseFeaturesTest extends ezcTestCase
{
    protected function setUp()
    {
        $uname = php_uname( 's' );
        if ( substr( $uname, 0, 7 ) == 'Windows' )
        {
            $this->markTestSkipped( 'Unix tests' );
        }
    }

    public function testSupportsLink()
    {
        $this->assertEquals( true, ezcBaseFeatures::supportsLink() );
    }

    public function testSupportsSymLink()
    {
        $this->assertEquals( true, ezcBaseFeatures::supportsSymLink() );
    }

    public function testSupportsUserId()
    {
        $this->assertEquals( true, ezcBaseFeatures::supportsUserId() );
    }

/*  // Need to find a way to make this test work, as setting global enviroment variables
    // is not working (putenv( "PATH=" ) doesn't unset $_ENV["PATH"])
    // One solution would be to use in the ezcBaseFeatures::getPath():
    // getenv( 'PATH' ) instead of $_ENV['PATH'] (but that won't work under IIS).
    public function testHasImageIdentifyNoPath()
    {
        $envPath = getenv( 'PATH' );
        putenv( "PATH=" );
        $this->assertEquals( false, ezcBaseFeatures::hasImageIdentify() );
        putenv( "PATH={$envPath}" );
    }
*/

    public function testHasImageConvert()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasImageConvert() );
    }

    public function testGetImageConvertExecutable()
    {
        $this->assertEquals( '/usr/bin/convert', ezcBaseFeatures::getImageConvertExecutable() );
    }

    public function testGetImageIdentifyExecutable()
    {
        $this->assertEquals( '/usr/bin/identify', ezcBaseFeatures::getImageIdentifyExecutable() );
    }

    public function testHasImageIdentify()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasImageIdentify() );
    }

    public function testHasExtensionSupport1()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasExtensionSupport( 'mysql' ) );
    }

    public function testHasFunction1()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasFunction( 'function_exists' ) );
    }

    public function testHasFunction2()
    {
        $this->assertEquals( false, ezcBaseFeatures::hasFunction( 'non_existant_funtion_in_php' ) );
    }

    public function testHasExtensionSupport2()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasExtensionSupport( 'date', '5.1.0' ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcBaseFeaturesTest");
    }
}
?>
