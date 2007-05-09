<?php
/**
 * File containing the ezcAuthenticationSessionOptions class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class containing the options for the session authentication filter.
 *
 * Example of use:
 * <code>
 * // create an options object
 * $options = new ezcAuthenticationSessionOptions();
 * $options->validity = 60;
 * $options->idKey = 'xxx';
 * $options->timestampKey = 'yyy';
 *
 * // use the options object when creating a new Session filter
 * $filter = new ezcAuthenticationSessionFilter( $options );
 *
 * // alternatively, you can set the options to an existing filter
 * $filter = new ezcAuthenticationSessionFilter();
 * $filter->setOptions( $options );
 * </code>
 *
 * @property int $validity
 *           The amount of seconds the session can be idle.
 * @property string $idKey
 *           The key to use in $_SESSION to hold the user ID of the user who is
 *           logged in.
 * @property string $timestampKey
 *           The key to use in $_SESSION to hold the authentication timestamp.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationSessionOptions extends ezcAuthenticationFilterOptions
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
        $this->validity = 1200; // seconds
        $this->idKey = 'ezcAuth_id';
        $this->timestampKey = 'ezcAuth_timestamp';

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
            case 'validity':
                if ( !is_numeric( $value ) || ( $value < 1 ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'int >= 1' );
                }
                $this->properties[$name] = $value;
                break;

            case 'idKey':
            case 'timestampKey':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}
?>
