<?php
/**
 * File containing the ezcTreeVisitorXHTMLOptions class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Class containing the options for the ezcTreeVisitorXHTMLOptions class.
 *
 * @property string $basePath
 *           Which string to prefix the href-targets with.
 * @property bool $addLinks
 *           Whether links should be generated or not.
 * @property bool $displayRootNode
 *           Whether the root node should be displayed.
 * @property string $xmlId
 *           The ID that should be set on the top level &lt;ul&gt; tag.
 * @property array(string) $highlightNodeIds
 *           Which IDs should have the 'highlight' CSS class added.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeVisitorXHTMLOptions extends ezcBaseOptions
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
        $this->basePath = '';
        $this->addLinks = true;
        $this->displayRootNode = false;
        $this->xmlId = null;
        $this->highlightNodeIds = array();

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
            case 'basePath':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                $this->properties[$name] = $value;
                break;

            case 'addLinks':
            case 'displayRootNode':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;

            case 'highlightNodeIds':
                if ( !is_array( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'array(string)' );
                }
                $this->properties[$name] = $value;
                break;

            case 'xmlId':
                if ( !is_null( $value ) && !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'null or string' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>
