<?php
/**
 * File containing the ezcMvcInfiniteLoopException class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when there are more internal redirects than allowed.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcInfiniteLoopException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcInfiniteLoopException
     *
     * @param int $redirectCount
     */
    public function __construct( $redirectCount )
    {
        $message = "{$redirectCount} redirects have occurred, there is a possible infinite redirect loop.";
        parent::__construct( $message );
    }
}
?>
