<?php
/**
 * File containing the test suite for the Webdav component.
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

require_once 'client_test_suite.php';
require_once 'client_test.php';

/**
 * Require test suites.
 */
require_once 'backend_memory_test.php';
require_once 'backend_file_test.php';

require_once 'path_factory_automatic_test.php';

require_once 'property_storage_test.php';
require_once 'property_storage_flagged_test.php';

require_once 'property_dead_test.php';
require_once 'property_creationdate_test.php';
require_once 'property_displayname_test.php';
require_once 'property_getcontentlanguage_test.php';
require_once 'property_getcontentlength_test.php';
require_once 'property_getcontenttype_test.php';
require_once 'property_getetagtest.php';
require_once 'property_getlastmodified_test.php';
require_once 'property_lockdiscovery_activelock_test.php';
require_once 'property_lockdiscovery_test.php';
require_once 'property_resourcetype_test.php';
require_once 'property_source_link_test.php';
require_once 'property_source_test.php';
require_once 'property_supportedlock_lockentry_test.php';
require_once 'property_supportedlock_test.php';

require_once 'request_copy_test.php';
require_once 'request_move_test.php';
require_once 'request_propfind_test.php';
require_once 'request_proppatch_test.php';
require_once 'request_lock_test.php';
require_once 'request_unlock_test.php';

require_once 'request_content_property_behaviour_test.php';

require_once 'response_error_test.php';
require_once 'response_get_test.php';
require_once 'response_options_test.php';
require_once 'response_test.php';

require_once 'transport_options_test.php';
require_once 'server_test.php';

require_once 'client_test_rfc.php';
require_once 'client_test_cadaver.php';

/**
 * Test suite for the Webdav component.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Webdav' );

        $this->addTest( ezcWebdavBasicServerTest::suite() );
        $this->addTest( ezcWebdavTransportOptionsTest::suite() );

        $this->addTest( ezcWebdavFlaggedPropertyStorageTest::suite() );
        $this->addTest( ezcWebdavPropertyStorageTest::suite() );

        $this->addTest( ezcWebdavCreationDatePropertyTest::suite() );
        $this->addTest( ezcWebdavDeadPropertyTest::suite() );
        $this->addTest( ezcWebdavDisplayNamePropertyTest::suite() );
        $this->addTest( ezcWebdavGetContentLanguagePropertyTest::suite() );
        $this->addTest( ezcWebdavGetContentLengthPropertyTest::suite() );
        $this->addTest( ezcWebdavGetContentTypePropertyTest::suite() );
        $this->addTest( ezcWebdavGetEtagPropertyTest::suite() );
        $this->addTest( ezcWebdavGetLastModifiedPropertyTest::suite() );
        $this->addTest( ezcWebdavLockDiscoveryPropertyActiveLockTest::suite() );
        $this->addTest( ezcWebdavLockDiscoveryPropertyTest::suite() );
        $this->addTest( ezcWebdavResourceTypePropertyTest::suite() );
        $this->addTest( ezcWebdavSourcePropertyLinkTest::suite() );
        $this->addTest( ezcWebdavSourcePropertyTest::suite() );
        $this->addTest( ezcWebdavSupportedLockPropertyLockentryTest::suite() );
        $this->addTest( ezcWebdavSupportedLockPropertyTest::suite() );

        $this->addTest( ezcWebdavCopyRequestTest::suite() );
        $this->addTest( ezcWebdavLockRequestTest::suite() );
        $this->addTest( ezcWebdavMoveRequestTest::suite() );
        $this->addTest( ezcWebdavPropFindRequestTest::suite() );
        $this->addTest( ezcWebdavPropPatchRequestTest::suite() );
        $this->addTest( ezcWebdavUnlockRequestTest::suite() );
        $this->addTest( ezcWebdavRequestPropertyBehaviourContentTest::suite() );
        
        $this->addTest( ezcWebdavErrorResonseTest::suite() );
        $this->addTest( ezcWebdavGetResponseTest::suite() );
        $this->addTest( ezcWebdavOptionsResponseTest::suite() );
        $this->addTest( ezcWebdavResponseTest::suite() );

        $this->addTest( ezcWebdavMemoryBackendTest::suite() );
        $this->addTest( ezcWebdavFileBackendTest::suite() );

        $this->addTest( ezcWebdavAutomaticPathFactoryTest::suite() );

        $this->addTest( ezcWebdavClientRfcTest::suite() );
        $this->addTest( ezcWebdavClientCadaverTest::suite() );
    }

    public static function suite()
    {
        return new ezcWebdavSuite( 'ezcWebdavSuite' );
    }
}
?>
