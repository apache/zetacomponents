<?php
/**
 * File containing the ezcAuthenticationOpenidOptions class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class containing the options for the OpenID authentication filter.
 *
 * Example of use:
 * <code>
 * // create an options object
 * $options = new ezcAuthenticationOpenidOptions();
 * $options->timeout = 5;
 * $options->timeoutOpen = 3;
 *
 * // use the options object when creating a new OpenID filter
 * $filter = new ezcAuthenticationOpenidFilter( $options );
 *
 * // alternatively, you can set the options to an existing filter
 * $filter = new ezcAuthenticationSessionFilter();
 * $filter->setOptions( $options );
 * </code>
 *
 * @property int $timeout
 *           The amount of seconds allowed as timeout for fetching content
 *           during HTML or Yadis discovery.
 * @property int $timeoutOpen
 *           The amount of seconds allowed as timeout when creating a connection
 *           with fsockopen() for the HTML or Yadis discovery.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationOpenidOptions extends ezcAuthenticationFilterOptions
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
        $this->timeout = 3; // seconds
        $this->timeoutOpen = 3; // seconds

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
            case 'timeout':
            case 'timeoutOpen':
                if ( !is_numeric( $value ) || ( $value < 1 ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'int >= 1' );
                }
                $this->properties[$name] = $value;
                break;
                
            default:
                parent::__set( $name, $value );
        }
    }
}
?>
