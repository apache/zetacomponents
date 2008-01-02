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
class testBaseInitClass
{
    public $configured = false;
    public static $instance;

    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new testBaseInitClass();
            ezcBaseInit::fetchConfig( 'testBaseInit', self::$instance );
        }
        return self::$instance;
    }
}
?>
