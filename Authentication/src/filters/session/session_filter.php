<?php
/**
 * File containing the ezcAuthenticationSessionFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Support for session authentication and saving of authentication information
 * between requests.
 *
 * Contains the methods:
 * - start - starts the session, calling the PHP function session_start()
 * - load - returns the information stored in the session key ezcAuth_id
 * - save - saves information in the session key ezcAuth_id and also saves
 *          the current timestamp in the session key ezcAuth_timestamp
 * - destroy - deletes the information stored in the session keys ezcAuth_id
 *             and ezcAuth_timestamp
 * - regenerateId - regenerates the PHPSESSID value
 *
 * Example of use (combined with the Htpasswd filter):
 * <code>
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSessionFilter();
 * $session->start();
 *
 * // retrieve the POST request information
 * $user = isset( $_POST['user'] ) ? $_POST['user'] : $session->load();
 * $password = isset( $_POST['password'] ) ? $_POST['password'] : null;
 * $credentials = new ezcAuthenticationPasswordCredentials( $user, $password );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->session = $session;
 * $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd' ) );
 * // add other filters if needed
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array(
 *              ezcAuthenticationHtpasswdFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
 *              ezcAuthenticationHtpasswdFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password',
 *              ezcAuthenticationSessionFilter::STATUS_EMPTY => '',
 *              ezcAuthenticationSessionFilter::STATUS_EXPIRED => 'Session expired'
 *              );
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         echo $err[$value];
 *     }
 * }
 * else
 * {
 *     // authentication succeeded, so allow the user to see his content
 * }
 * </code>
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationSessionFilter extends ezcAuthenticationFilter implements ezcAuthenticationSession
{
    /**
     * The session is empty; normal behaviour is to continue with the other filters.
     */
    const STATUS_EMPTY = 1;

    /**
     * The session expired; normal behaviour is to regenerate the session ID.
     */
    const STATUS_EXPIRED = 2;

    /**
     * Creates a new object of this class.
     *
     * @param ezcAuthenticationSessionOptions $options Options for the authentication filter
     */
    public function __construct( ezcAuthenticationSessionOptions $options = null )
    {
        $this->options = ( $options === null ) ? new ezcAuthenticationSessionOptions() : $options;
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $this->start();
        if ( isset( $_SESSION[$this->options->timestampKey] ) && 
             time() - $_SESSION[$this->options->timestampKey] >= $this->options->validity )
        {
            $this->destroy();
            $this->regenerateId();
            return self::STATUS_EXPIRED;
        }
        if ( $this->load() !== null )
        {
            return self::STATUS_OK;
        }
        return self::STATUS_EMPTY;
    }

    /**
     * Starts the session.
     *
     * This function must be called before sending any headers to the client.
     */
    public function start()
    {
        if ( session_id() === '' && PHP_SAPI !== 'cli' )
        {
            session_start();
        }
    }

    /**
     * Loads the authenticated username from the session or null if it doesn't exist.
     *
     * @return string
     */
    public function load()
    {
        return isset( $_SESSION[$this->options->idKey] ) ? $_SESSION[$this->options->idKey] :
                                                                null;
    }

    /**
     * Saves the authenticated username and the current timestamp in the session
     * variables.
     *
     * @param string $data Information to save in the session, usually username
     */
    public function save( $data )
    {
        $_SESSION[$this->options->idKey] = $data;
        $_SESSION[$this->options->timestampKey] = time();
    }

    /**
     * Removes the variables used by this class from the session variables.
     */
    public function destroy()
    {
        unset( $_SESSION[$this->options->idKey] );
        unset( $_SESSION[$this->options->timestampKey] );
    }
    
    /**
     * Regenerates the session ID.
     */
    public function regenerateId()
    {
        if ( !headers_sent() )
        {
            // ???? seems that PHPSESSID is not regenerated if session is destroyed first????
            // session_destroy();
            session_regenerate_id();
        }
    }
}
?>
