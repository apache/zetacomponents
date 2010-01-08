<?php
/**
 * File containing the ezcAuthenticationOpenidFileStoreHelper class.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Class which exposes the protected functions from ezcAuthenticationOpenidFileStore
 * and contains other needed methods for OpenID file store tests.
 *
 * For testing purposes only.
 *
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationOpenidFileStoreHelper extends ezcAuthenticationOpenidFileStore
{
    /**
     * Returns the filenames from a provided path.
     *
     * @param string $path The path to return the filenames from
     * @return array(string)
     */
    public static function getFiles( $path )
    {
        $result = array();
        if ( $fh = opendir( $path ) )
        {
            while ( ( $file = readdir( $fh ) ) !== false )
            {
                $result[] = $file;
            }
            closedir( $fh );
        }
        return $result;
    }

    /**
     * Creates a valid filename from the provided string.
     *
     * @param string $value A string which needs to be used as a valid filename
     * @return string
     */
    public function convertToFilename( $value )
    {
        return parent::convertToFilename( $value );
    }
}
?>
