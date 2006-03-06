<?php
/**
* ezcSystemInfo
*
* @package SystemInformation
* @subpackage Tests
* @version //autogentag//
* @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
* @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
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
class ezcSystemInformationSuite extends ezcTestSuite
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
