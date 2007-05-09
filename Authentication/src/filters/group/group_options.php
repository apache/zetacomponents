<?php
/**
 * File containing the ezcAuthenticationGroupOptions class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class containing the options for group authentication filter.
 *
 * Example of use:
 * <code>
 * $options = new ezcAuthenticationGroupOptions();
 * $options->mode = ezcAuthenticationGroupFilter::MODE_AND;
 *
 * // $filter1 and $filter2 are authentication filters which need all to succeed
 * // in order for the group to succeed
 * $filter = new ezcAuthenticationGroupFilter( array( $filter1, $filter2 ), $options );
 * </code>
 *
 * @property int $mode
 *           The way of grouping the authentication filters. Possible values:
 *            - ezcAuthenticationGroupFilter::MODE_OR (default): at least one
 *              filter in the group needs to succeed in order for the group to
 *              succeed.
 *            - ezcAuthenticationGroupFilter::MODE_AND: all filters in the group
 *              need to succeed in order for the group to succeed.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationGroupOptions extends ezcAuthenticationFilterOptions
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
        $this->mode = ezcAuthenticationGroupFilter::MODE_OR;

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
                $modes = array(
                                ezcAuthenticationGroupFilter::MODE_OR,
                                ezcAuthenticationGroupFilter::MODE_AND
                              );
                if ( !in_array( $value, $modes, true ) )
                {
                    throw new ezcBaseValueException( $name, $value, implode( ', ', $modes ) );
                }
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}
?>
