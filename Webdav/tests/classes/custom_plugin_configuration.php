<?php
/**
 * File containing the fooCustomWebdavPluginConfiguration class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Mock class to remove "abstract".
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
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
                'beforeExtractLiveProperty' => array(
                    array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                    array(  $this, 'testCallback' ),
                ),
                'afterExtractLiveProperty' => array(
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
