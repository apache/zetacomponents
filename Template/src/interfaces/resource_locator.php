<?php
/**
 * File containing the ezcTemplateResourceLocator class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Interface for classes which locates the real file location of a location
 * request string.
 *
 * The template manager will use the class to find the source code or compiled
 * code from the TRL (template resource locator).
 *
 * Finding source code files is done with the findSource() method and compiled
 * code with the findCompiled() method.
 *
 * To parse the locator strings the static function parseLocationString() can be
 * used.
 *
 * The definition of the TRL is:
 * <code>
 * TRL := LOCATOR : LOCATION
 * LOCATOR := A-Za-z0-9_
 * LOCATION := any character
 * </code>
 * If the LOCATOR is missing it will use the default locator and use the whole
 * string as the LOCATION.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateResourceLocator
{

    /**
     * Finds the source code using the location $location and returns a source code
     * object for it.
     *
     * @note The function will not guarantee that the file actually exists, check
     * that in the returned object.
     *
     * @param string $location The location string which is used to determine the
     * real location of the source file.
     * @return ezcTemplateSourceCode
     */
    abstract public function findSource( $location );

    /**
     * Finds the compiled code using the location $location and returns a compiled
     * code object for it.
     *
     * @note The function will not guarantee that the file actually exists, check
     * that in the returned object.
     *
     * @param string $location The location string which is used to determine the
     * real location of the compiled file.
     * @return ezcTemplateCompiledCode
     * @todo This method might not be needed, instead provide a findSourcePath which
     *       can be used to find the compiled path.
     */
    abstract public function findCompiled( $location );

    /**
     * Parses the location string $location into a ezcTemplateLocation object which
     * contains the locator name and the stream string separated.
     *
     * @param string $location
     * @return ezcTemplateLocation
     */
    public static function parseLocationString( $location )
    {
        if ( preg_match( "#^([a-zA-Z0-9_]+):(.*)$#", $location, $matches ) )
            return new ezcTemplateLocation( $matches[1], $matches[2] );
        return new ezcTemplateLocation( false, $location );
    }

}
?>
