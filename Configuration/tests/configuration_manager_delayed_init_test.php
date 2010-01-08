<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

require_once( "test_classes.php" );

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationManagerDelayedInitTest extends ezcTestCase
{
    private $dbg;

    public function tearDown()
    {
        $cfg = ezcConfigurationManager::getInstance();
        $cfg->reset();
    }

    public function testDelayedInit()
    {
        ezcBaseInit::setCallback( 'ezcInitConfigurationManager', 'testDelayedInitConfigurationManager' );
        $cfg = ezcConfigurationManager::getInstance();
        $this->assertAttributeEquals( 'ezcConfigurationIniReader', 'readerClass', $cfg );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcConfigurationManagerDelayedInitTest");
    }
}

?>
