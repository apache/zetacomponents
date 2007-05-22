<?php
/**
 * File containing the ezcAuthenticationSession interface.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Interface to provide session functionality.
 *
 * @package Authentication
 * @version //autogen//
 */
interface ezcAuthenticationSession
{
    /**
     * Starts the session.
     *
     * This function must be called before sending any headers to the client.
     */
    public function start();

    /**
     * Loads the authenticated username from the session or null if it doesn't exist.
     *
     * @return string
     */
    public function load();

    /**
     * Saves variables used by this class in the session variables.
     *
     * @param string $sessionInfo Information to be saved in the session
     */
    public function save( $sessionInfo );

    /**
     * Removes the variables used by this class from the session variables.
     */
    public function destroy();

    /**
     * Regenerates the session ID.
     */
    public function regenerateId();
}
?>
