<?php
/**
 * File containing the fooCustomWebdavPluginConfiguration class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Mock class to remove "abstract".
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogen//
 */
class fooCustomWebdavPluginConfiguration extends ezcWebdavPluginConfiguration
{
    public $foo;

    public $callbackCalled = 0;

    public $namespace = 'foonamespace';

    public $hooks;

    public $init = false;

    public function getHooks()
    {
        return ( isset( $this->hooks ) ? $this->hooks : array(
            'ezcWebdavTransport' => array(
                'beforeParseRequest' => array(
                    array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                    array(  $this, 'testCallback' ),
                ),
                'afterProcessResponse' => array(
                    array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                    array( $this, 'testCallback' )
                ),
            ),
        ) );
    }

    public function testCallback()
    {
        ++$this->callbackCalled;
    }


    public function getNamespace()
    {
        return $this->namespace;
    }

    public function init()
    {
        $this->init = true;
    }
}



?>
