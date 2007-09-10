<?php
/**
 * File containing the ezcWebdavMemoryBackendOptions class
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Class containing the options for the memory backend.
 *
 * @property string $pathFactory
 *           Class used to transform real paths into request paths.
 *
 * @package Webdav
 * @version //autogen//
 * @access private
 */
class ezcWebdavMemoryBackendOptions extends ezcBaseOptions
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

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>
