<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

/**
 * Include classes used in tests.
 */

require_once 'formatters/html_formatter_data_structures.php';
require_once 'formatters/test_reporter.php';
require_once 'wrappers/fake_wrapper.php';

/**
 * File included in all tests.
 *
 * @package Debug
 * @subpackage Tests
 */
class testDelayedInitDebug implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->setOutputFormatter( new TestReporter() );
    }
}
?>
