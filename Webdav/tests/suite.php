<?php
/**
 * ezcGraphSuite
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Require test suites.
 */
require_once 'server_test.php';
require_once 'server_options_test.php';
require_once 'path_factory_test.php';

/**
* Test suite for ImageAnalysis package.
*
 * @package Webdav
 * @subpackage Tests
*/
class ezcWebdavSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Webdav' );

        $this->addTest( ezcWebdavBasicServerTest::suite() );
        $this->addTest( ezcWebdavServerOptionsTest::suite() );
        $this->addTest( ezcWebdavPathFactoryTest::suite() );
    }

    public static function suite()
    {
        return new ezcWebdavSuite( 'ezcWebdavSuite' );
    }
}
?>
