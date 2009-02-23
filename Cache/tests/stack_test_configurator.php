<?php
/**
 * ezcCacheStackTestConfigurator
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Configurator class
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackTestConfigurator implements ezcCacheStackConfigurator
{
    public static $storages  = array();

    public static $metaStorage;

    public static $options;

    public static function configure( ezcCacheStack $stack )
    {
        foreach ( self::$storages as $storageConf )
        {
            $stack->pushStorage( $storageConf );
        }
        if ( self::$metaStorage !== null )
        {
            $stack->options->metaStorage = self::$metaStorage;
        }
        if ( self::$options !== null )
        {
            $stack->options = self::$options;
        }
    }

    public static function reset()
    {
        self::$storages    = array();
        self::$metaStorage = null;
        self::$options     = null;
    }
}

?>
