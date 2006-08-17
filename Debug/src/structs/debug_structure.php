<?php
/**
 * File containing the ezcDebugStructure class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The ezcDebugStructure is used internally by the debug system to store
 * debug messages.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugStructure
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        $this->properties[$name] = $value;
    }

   /**
     * Returns the property $name.
     *
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        return $this->properties[$name];
    }

    /**
     * Generates string output of the debug messages.
     *
     * The output generated is each value listed in the form "'key' => 'value'".
     *
     * @return string
     */
    public function toString()
    {
        $str = "";
        foreach ( $properties as $key => $value )
        {
            $str .= "$key => $value\n";
        }

        return $str;
    }
}
?>
