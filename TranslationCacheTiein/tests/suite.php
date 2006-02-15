<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'translation_backend_cache_test.php';

/**
 * @package Translation
 * @subpackage Tests
 */
class ezcTranslationCacheTieinSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("TranslationCacheTiein");

        $this->addTest( ezcTranslationCacheBackendTest::suite() );
    }

    public static function suite()
    {
        return new ezcTranslationCacheTieinSuite();
    }
}

?>
