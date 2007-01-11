<?php
/**
 * File containing the ezcTemplateCompilationFailedException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateCompilationFailedException extends ezcTemplateException
{
    /**
     * Creates a exception for failed compilations, error message is
     * specified by caller.
     *
     * @param string $msg
     */
    public function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>
