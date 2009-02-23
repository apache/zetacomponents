<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'translation_test.php';
require_once 'translation_backend_ts_test.php';
require_once 'translation_filter_borkify_test.php';
require_once 'translation_filter_leetify_test.php';
require_once 'translation_manager_test.php';

/**
 * @package Translation
 * @subpackage Tests
 */
class ezcTranslationSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Translation");

        $this->addTest( ezcTranslationTest::suite() );
        $this->addTest( ezcTranslationTsBackendTest::suite() );
        $this->addTest( ezcTranslationManagerTest::suite() );
        $this->addTest( ezcTranslationFilterBorkifyTest::suite() );
        $this->addTest( ezcTranslationFilterLeetifyTest::suite() );
    }

    public static function suite()
    {
        return new ezcTranslationSuite();
    }
}

?>
