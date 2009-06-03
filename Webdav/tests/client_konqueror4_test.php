<?php
/**
 * Client test for Konqueror 4.
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
 * Client test for Konqueror 4.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavKonqueror4ClientTest extends ezcWebdavTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'Konqueror 4',
            'clients/konqueror_4.php',
            new ezcWebdavClientTestContinuousSetup()
        );
    }
}

?>
