<?php
/**
 * File containing the ezcConfigurationException class
 *
 * @package Configuration
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if there were errors while parsing a file while the
 * parser was not in validation mode.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationParseErrorException extends ezcConfigurationException
{
    function __construct( $fileName, $lineNr, $description )
    {
        parent::__construct( "{$description} in '{$fileName}', line '{$lineNr}'." );
    }
}
?>
