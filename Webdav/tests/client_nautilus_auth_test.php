<?php
/**
 * Client test for Nautilus.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'client_test_suite.php';
require_once 'client_test_continuous_setup.php';

/**
 * Client test for Nautilus.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavNautilusAuthClientTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'Nautilus Auth',
            'clients/nautilus_auth.php',
            new ezcWebdavClientTestContinuousSetup()
        );
    }
}

?>
