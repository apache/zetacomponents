<?php
/**
 * Client test for InternetExplorer 7 (auth).
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'client_test_suite.php';
require_once 'client_test_continuous_ie_auth_setup.php';

/**
 * Client test for InternetExplorer 7 (auth).
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavIe7AuthClientTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'InternetExplorer 7 (auth)',
            'clients/ie7_auth.php',
            new ezcWebdavClientTestContinuousIeAuthSetup()
        );
    }
}

?>
