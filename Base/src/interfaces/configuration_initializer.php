<?php
/**
 * File containing the ezcBaseConfigurationInitializer class
 *
 * @package Base
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface that classes need to implement to act as an
 * callback initializer class to work with the delayed initialization mechanism.
 *
 * @package Base
 * @version //autogen//
 */
interface ezcBaseConfigurationInitializer
{
    /**
     * Sets the options for the writer.
     *
     * The options will be used the next time the save() method is called. The
     * $options array is an associative array with the options for the writer.
     * It depends on the specific writer which options are allowed here.
     *
     * @param array $options
     */
    static public function configureObject( $options );
}
?>
