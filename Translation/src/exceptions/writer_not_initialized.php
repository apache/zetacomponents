<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown when methods are called that require a ContextWriter to be
 * initialized.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationWriterNotInitializedException extends ezcTranslationException
{
    function __construct()
    {
        parent::__construct( "The writer is not initialized with the initWriter() method." );
    }
}
?>
