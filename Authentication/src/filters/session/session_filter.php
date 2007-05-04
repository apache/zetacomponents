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
 * Example:
 * <code>
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSessionFilter();
 * $session->start();
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
 *     $err = array();
 *     $err["user"] = "";
 *     $err["password"] = "";
 *     $err["session"] = "";
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         switch ( $key )
 *         {
 *             case 'ezcAuthenticationHtpasswdFilter':
 *                 if ( $value === ezcAuthenticationHtpasswdFilter::STATUS_USERNAME_INCORRECT )
 *                 {
 *                     $err["user"] = "<span class='error'>Username incorrect</span>";
 *                 }
 *                 if ( $value === ezcAuthenticationHtpasswdFilter::STATUS_PASSWORD_INCORRECT )
 *                 {
 *                     $err["password"] = "<span class='error'>Password incorrect</span>";
 *                 }
 *                 break;
 *             case 'ezcAuthenticationSessionFilter':
 *                 if ( $value === ezcAuthenticationSessionFilter::STATUS_EXPIRED )
 *                 {
 *                     $err["session"] = "<span class='error'>Session expired</span>";
 *                 }
 *                 break;
 *         }
 *     }
 *     // use $err array (with a Template object for example) to display the login form
 *     // to the user with "Password incorrect" message next to the password field, etc...
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
     * The key to use in $_SESSION to hold the user ID of the user who is logged in.
     *
     * var string
     */
    private $sessionKey = 'ezcAuth_id';

    /**
     * The key to use in $_SESSION to hold the authentication timestamp.
     *
     * var string
     */
    private $timestampKey = 'ezcAuth_timestamp';

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
        if ( isset( $_SESSION[$this->timestampKey] ) && 
             time() - $_SESSION[$this->timestampKey] >= $this->options->validity )
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
        return isset( $_SESSION[$this->sessionKey] ) ? $_SESSION[$this->sessionKey] :
                                                       null;
    }

    /**
     * Saves the authenticated username and the current timestamp in the session
     * variables.
     *
     * @param string $sessionInfo Information to save in the session, usually username
     */
    public function save( $sessionInfo )
    {
        $_SESSION[$this->sessionKey] = $sessionInfo;
        $_SESSION[$this->timestampKey] = time();
    }

    /**
     * Removes the variables used by this class from the session variables.
     */
    public function destroy()
    {
        unset( $_SESSION[$this->sessionKey] );
        unset( $_SESSION[$this->timestampKey] );
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
