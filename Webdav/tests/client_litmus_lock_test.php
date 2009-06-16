<?php
/**
 * Client test for Litmus (with locking).
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'client_test_suite.php';
require_once 'client_test_continuous_lock_setup.php';

/**
 * Client test for Litmus (with locking).
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavLitmusLockClientTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'Litmus (lock)',
            'clients/litmus_lock.php',
            new ezcWebdavClientTestContinuousLockSetup()
        );
    }
}

?>
