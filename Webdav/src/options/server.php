<?php
/**
 * File containing the ezcWebdavServerOptions class
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the options for basic webdav server.
 *
 * @property string $pathFactory
 *           Class used to transform real paths into request paths.
 * @property bool $modSendfile
 *           Server module mod_sendfile may be used for file sendouts.
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavServerOptions extends ezcBaseOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['pathFactory'] = 'ezcWebdavPathFactory';
        $this->properties['modSendfile'] = false;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'pathFactory':
                if ( !is_string( $value ) ||
                     !is_subclass_of( $value, 'ezcWebdavPathFactory' ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcWebdavPathFactory' );
                }

                $this->properties[$name] = $value;
                break;

            case 'modSendfile':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }

                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>
