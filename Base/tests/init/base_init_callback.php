<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test class for ezcBaseInitTest.
 *
 * @package Base
 * @subpackage Tests
 */
class testBaseInitCallback implements ezcBaseConfigurationInitializer
{
    static public function configureObject( $objectToConfigure )
    {
        $objectToConfigure->configured = true;
    }
}
?>
