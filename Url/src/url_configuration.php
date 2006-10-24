<?php
/**
 * File containing the ezcUrlConfiguration class.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 */

/**
 * @package Url
 * @version //autogen//
 */
class ezcUrlConfiguration
{
    /**
     * Flag for specifying single arguments for unordered parameters.
     */
    const SINGLE_ARGUMENT = 1;

    /**
     * Flag for specifying multiple arguments for unordered parameters.
     */
    const MULTIPLE_ARGUMENTS = 2;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Constructs a new ezcUrlConfiguration object.
     */
    public function __construct()
    {
        $this->basedir = null;
        $this->script = null;
        $this->unorderedDelimiters = array( '(', ')' );
        $this->orderedParameters = array();
        $this->unorderedParameters = array();
    }

    /**
     * Initializes the properties with default values.
     */
    public function defaultConfiguration()
    {
        $this->script = 'index.php';
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'basedir':
            case 'script':
            case 'unorderedDelimiters':
            case 'orderedParameters':
            case 'unorderedParameters':
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Returns the property $name.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'basedir':
            case 'script':
            case 'unorderedDelimiters':
            case 'orderedParameters':
            case 'unorderedParameters':
                return $this->properties[$name];
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    public function addOrderedParameter( $name )
    {
        $this->properties['orderedParameters'][$name] = count( $this->properties['orderedParameters'] );
    }

    public function addUnorderedParameter( $name, $type = null )
    {
        if ( $type == null )
        {
            $type = self::SINGLE_ARGUMENT;
        }
        $this->properties['unorderedParameters'][$name] = $type;
    }
}
?>
