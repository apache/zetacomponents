<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */
/**
 * Thrown when methods are called that require a ContextReader to be
 * initialized.
 *
 * @package Translation
 */
class ezcTranslationReaderNotInitializedException extends ezcTranslationException
{
    function __construct()
    {
        parent::__construct( "The reader is not initialized with the initReader() method." );
    }
}
?>
