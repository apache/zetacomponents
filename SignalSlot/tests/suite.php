<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "signal_collection_test.php" );
require_once( "static_connections_test.php" );
require_once( "static_connections_base_test.php" );
require_once( "options_test.php" );

/**
 * @package PhpGenerator
 * @subpackage Tests
 */
class ezcSignalSlotSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("SignalSlot");

        $this->addTest( ezcSignalStaticConnectionsTest::suite() );
        $this->addTest( ezcSignalStaticConnectionsBaseTest::suite() );
        $this->addTest( ezcSignalCollectionTest::suite() );
        $this->addTest( ezcSignalSlotCollectionOptionsTest::suite() );
    }

    public static function suite()
    {
        return new ezcSignalSlotSuite();
    }
}
?>
