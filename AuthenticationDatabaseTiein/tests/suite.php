<?php
/**
 * File containing the ezcAuthenticationDatabaseTieinSuite class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "filters/database/database_test.php" );

/**
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationDatabaseTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "AuthenticationDatabaseTiein" );
        ezcBase::addClassRepository( '/home/as/dev/ezcomponents/experimental', '/home/as/dev/ezcomponents/experimental/autoload' );
        
        $this->addTest( ezcAuthenticationDatabaseTest::suite() );
    }

    public static function suite()
    {
        return new ezcAuthenticationDatabaseTieinSuite();
    }
}
?>
