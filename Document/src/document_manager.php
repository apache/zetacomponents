<?php
/**
 * File containing the ezcDocumentManager class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * A ducument type  handler manager class.
 *
 * The document manager manages a list of document handlers for document types,
 * identified by a string. You may overwrite the used implementation for one or
 * all formats, or add custom implementations for new document types.
 *
 * <code>
 *  // Get a RST document from a file
 *  $doc = ezcDocumentManager::loadFile( 'rst', '/path/to/my.rst' );
 *
 *  // Overwrite the used implementation with a custom RST handler
 *  ezcDocumentManager::setHandler( 'rst', 'myRsthandler' );
 *  // This will now use the custom handler
 *  $doc = ezcDocumentManager::loadFile( 'rst', '/path/to/my.rst' );
 * </code>
 * 
 * @package Document
 * @version //autogen//
 * @mainclass
 */
class ezcDocumentManager
{
    /**
     * Predefined handler list.
     *
     * @var array
     */
    protected static $handlers = array(
        'rst'   => 'ezcDocumentRst',
        // ...
    );

    /**
     * Load file with specified handler
     * 
     * @param string $format 
     * @param string $file 
     * @return ezcDocument
     */
    public static function loadFile( $format, $file )
    {
        // @TODO: Implement
    }

    /**
     * Set handler for format
     *
     * Set the format handler for $format to the specified handler class, which
     * should extend from ezcDocument.
     * 
     * @param string $format 
     * @param string $handler 
     * @return void
     */
    public static function setHandler( $format, $handler )
    {
        // @TODO: Implement
    }
}
?>
