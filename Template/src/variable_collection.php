<?php
/**
 * File containing the ezcTemplateVariableCollection class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Contains the template variables.
 *
 * The next example sets and gets variables:
 *
 * <code>
 * $collection = new ezcTemplateVariableCollection();
 * $collection->character = "Londo Mollari";
 * $collection->actor = "Peter Jurasik";
 * $collection->race = "Centauri";
 *
 * echo "Race: " . $collection->race;
 * </code>
 *
 * The next example shows all variables using the iterator. 
 * <code>
 * <?php
 * $send = new ezcTemplateVariableCollection();
 *
 * $send->red = "FF0000";
 * $send->green = "00FF00";
 * $send->blue = "0000FF";
 *
 * foreach ( $send as $name => $value )
 * {
 *     echo ( "$name  -> $value\n" );
 * }
 * ?>
 * </code>
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateVariableCollection implements Iterator
{
    /**
     * The collection where all variables are stored. Each entry is an
     * ezcTemplateVariable object and is looked up with the name of the variable.
     * @var array
     */
    private $variables;

    /**
     * Initialises an empty collection of variables.
     *
     * @note To initialise it with existing variables pass them as the $variables
     * parameter.
     *
     * @param array $variables An array of variables to initialise the collection
     * with. The default is an empty collection.
     */
    public function __construct( $variables = array() )
    {
        $this->variables = $variables;
    }

    /** 
     * Returns the value of the variable $name.
     *
     * @return mixed
     */
    public function __get( $name )
    {
        if( isset( $this->variables[$name] ) ) 
        {
            $value = $this->variables[$name];
            if ( is_array( $value ) )
            {
                // Ridiculous but needed.
                return (array) $value;
            }
            else
            {
                return $value;
            }
        }
        else
        {
            return null;
        }
    }

    /**
     * Sets the value $value to the variable $name.
     *
     * NOTE: If you want to assign an array be VERY careful. Do NOT write:
     * <code>
     * $v->myProp = array();
     * $v->myProp[] = "Hello";
     * </code>
     *
     * Because 'myProp' will still be an empty array. (Stupid PHP)
     */
    public function __set( $name, $value )
    {
        $this->variables[$name] = $value;
    }

    /**
     * Returns true if the variable $name is set.
     *
     * @return bool
     */
    public function __isset( $name )
    {
        return array_key_exists( $name, $this->variables ) && isset( $this->variables[$name] ); 
    }

    /**
     * Returns all variables in an array.
     *
     * @return array(ezcTemplateVariable)
     */
    public function getVariableArray()
    {
        return $this->variables;
    }

    /**
     * Iterator rewind method
     */
    public function rewind() 
    {
        reset( $this->variables );
    }
 
    /**
     * Returns the current variable
     */
    public function current() 
    {
        return current( $this->variables );
    }

    /**
     * Returns the current key.
     */
    public function key() 
    {
        return key( $this->variables );
    }
 
    /**
     * Proceed to the next element.
     */
    public function next() 
    {
        return next( $this->variables );
    }

    /**
     * Returns true if the iterator is at a valid location.
     */
    public function valid() 
    {
        return ( $this->current() !== false );
    }

    /**
     * Removes the variable named $name from the collection. 
     *
     * If the variable doesn't exist, it returns false.
     *
     * @param string $name The name of the variable to remove.
     */
    public function removeVariable( $name )
    {
        if ( !isset( $this->variables[$name] ) )
        {
            return false;
        }

        unset( $this->variables[$name] );
        return true;
    }
}
?>
