<?php
/**
 * ezcSystemInfo
 *
 * @package SystemInformation
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require test suite for SystemInformation class.
 */
require_once 'sysinfo_test.php';

/**
 * Test suite for SystemInformation package.
 *
 * @package SystemInformation
 * @subpackage Tests
 */
class ezcSystemInformationSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "SystemInformation" );
        $this->addTest( ezcSystemInfoTest::suite() );
    }

    public static function suite()
    {
        return new ezcSystemInformationSuite( "ezcSystemInformationSuite" );
    }
}
?>
