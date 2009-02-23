<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * Test class for ezcUrlConfigurationTest.
 *
 * @package Url
 * @subpackage Tests
 */
class testDelayedInitUrlConfiguration implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->addOrderedParameter( 'section' );
        $object->addUnorderedParameter( 'article' );
    }
}
?>
