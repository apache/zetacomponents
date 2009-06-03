<?php
/**
 * RFC conformance client test.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'test_case.php';
require_once 'client_test_suite.php';
require_once 'client_test_rfc_setup.php';

/**
 * RFC conformance client test.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavRfcClientTest extends ezcWebdavTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'RFC',
            'clients/rfc.php',
            new ezcWebdavClientTestRfcSetup()
        );
    }
}

?>
