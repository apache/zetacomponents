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
 * $options->requestSource = $_POST;
 *
 * // use the options object when creating a new OpenID filter
 * $filter = new ezcAuthenticationOpenidFilter( $options );
 *
 * // alternatively, you can set the options to an existing filter
 * $filter = new ezcAuthenticationSessionFilter();
 * $filter->setOptions( $options );
 * </code>
 *
 * @property int $mode
 *           The OpenID mode to use for authentication. It is either dumb
 *           (ezcAuthenticationOpenidFilter::MODE_DUMB, default) or smart
 *           (ezcAuthenticationOpenidFilter::MODE_SMART). In dumb mode
 *           the OpenID server does most of the work, but an extra check
 *           is required (check_authentication step). In smart mode the
 *           server and the OpenIP provider establish a shared secret (with
 *           an expiry period) that is used to sign the responses, so the
 *           check_authentication step is not required.
 * @property int $timeout
 *           The amount of seconds allowed as timeout for fetching content
 *           during HTML or Yadis discovery.
 * @property int $timeoutOpen
 *           The amount of seconds allowed as timeout when creating a connection
 *           with fsockopen() for the HTML or Yadis discovery.
 * @property array(string=>mixed) $requestSource
 *           From where to get the parameters returned by the OpenID provider.
 *           Default is $_GET.
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
        $this->mode = ezcAuthenticationOpenidFilter::MODE_DUMB; // stateless mode
        $this->timeout = 3; // seconds
        $this->timeoutOpen = 3; // seconds
        $this->requestSource = ( $_GET !== null ) ? $_GET : array();

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
            case 'mode':
                $allowedValues = array(
                                        ezcAuthenticationOpenidFilter::MODE_DUMB,
                                        ezcAuthenticationOpenidFilter::MODE_SMART
                                      );
                if ( !is_numeric( $value ) || ( in_array( $value, $allowedValues ) )
                {
                    throw new ezcBaseValueException( $name, $value, implode( ', ', $allowedModes ) );
                }
                $this->properties[$name] = $value;
                break;

            case 'timeout':
            case 'timeoutOpen':
                if ( !is_numeric( $value ) || ( $value < 1 ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'int >= 1' );
                }
                $this->properties[$name] = $value;
                break;

            case 'requestSource':
                if ( !is_array( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'array' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}
?>
