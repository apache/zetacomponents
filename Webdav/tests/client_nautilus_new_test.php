<?php
/**
 * Client test for Nautilus (new).
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'test_case.php';
require_once 'client_test_suite.php';
require_once 'client_test_continuous_setup.php';

/**
 * Client test for Nautilus (new).
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavNautilusNewClientTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'Nautilus (new)',
            'clients/nautilus_new.php',
            new ezcWebdavClientTestContinuousSetup()
        );
    }
}

?>
