<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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

        $this->addTest( ezcSignalCollectionTest::suite() );
        $this->addTest( ezcSignalStaticConnectionsTest::suite() );
        $this->addTest( ezcSignalStaticConnectionsBaseTest::suite() );
    }

    public static function suite()
    {
        return new ezcSignalSlotSuite();
    }
}
?>
