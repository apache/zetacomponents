<?php
/**
 * File containing the ezcWebdavUnlockRequest class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Unlockright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Abstract representation of a UNLOCK request.
 *
 * An instance of this class represents the WebDAV UNLOCK request.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Unlockright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
class ezcWebdavUnlockRequest extends ezcWebdavRequest
{
    /**
     * Validates the headers set in this request.
     *
     * This method validates that all required headers are available and that
     * all feasible headers for this request have valid values.
     *
     * @return void
     *
     * @throws ezcWebdavMissingHeaderException
     *         if a required header is missing.
     * @throws ezcWebdavInvalidHeaderException
     *         if a header is present, but its content does not validate.
     */
    public function validateHeaders()
    {
        if ( isset( $this->headers['Lock-Token'] ) === false )
        {
            throw new ezcWebdavMissingHeaderException( 'Lock-Token' );
        }

        // Validate common HTTP/WebDAV headers
        parent::validateHeaders();
    }
}

?>
