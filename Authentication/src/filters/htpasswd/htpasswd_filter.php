<?php
/**
 * File containing the ezcAuthenticationHtpasswdFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Filter to authenticate against an Unix htpasswd file.
 *
 * It supports files created with the htpasswd command options
 *   -m (MD5 encryption - different than the PHP md5() function)
 *   -d (CRYPT encryption)
 *   -s (SHA encryption)
 *   -p (plain text)
 *
 * The encryption used for the password field in the file will be detected
 * automatically.
 *
 * The password property can be specified as plain text or in encrypted form,
 * depending on the option 'plain' in the ezcAuthenticationHtpasswdOptions object
 * used as options.
 *
 * Example:
 * <code>
 * $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e' );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->session = new ezcAuthenticationSessionFilter();
 * $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd' ) );
 * // add other filters if needed
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array();
 *     $err["user"] = "";
 *     $err["password"] = "";
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
 * @property string $file
 *                  The path and file name of the htpasswd file to use.
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationHtpasswdFilter extends ezcAuthenticationFilter
{
    /**
     * Username is not found in the htpasswd file.
     */
    const STATUS_USERNAME_INCORRECT = 1;

    /**
     * Password is incorrect.
     */
    const STATUS_PASSWORD_INCORRECT = 2;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Creates a new object of this class.
     *
     * @param string $file The path and file name of the htpasswd file to use
     * @param ezcAuthenticationHtpasswdOptions $options Options for this class
     */
    public function __construct( $file, ezcAuthenticationHtpasswdOptions $options = null )
    {
        $this->file = $file;
        $this->options = ( $options === null ) ? new ezcAuthenticationHtpasswdOptions() : $options;
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @throws ezcBaseFileNotFoundException
     *         if the $value file does not exist
     * @throws ezcBaseFilePermissionException
     *         if the $value file cannot be opened for reading
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'file':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }

                if ( !file_exists( $value ) )
                {
                    throw new ezcBaseFileNotFoundException( $value );
                }

                if ( !is_readable( $value ) )
                {
                    throw new ezcBaseFilePermissionException( $value, ezcBaseFileException::READ );
                }

                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'file':
                return $this->properties[$name];

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'file':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationPasswordCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $fh = fopen( $this->file, 'r' );
        $found = false;
        while ( $line = fgets( $fh ) )
        {
            if ( substr( $line, 0, strlen( $credentials->id ) + 1 ) === $credentials->id . ':' )
            {
                $found = true;
                break;
            }
        }
        fclose( $fh );
        if ( $found )
        {
            $parts = split( ':', $line );
            $hashFromFile = trim( $parts[1] );
            if ( substr( $hashFromFile, 0, 6 ) === '$apr1$' )
            {
                $password = ( $this->options->plain ) ? $this->apr1( $credentials->password, $hashFromFile ) :
                                                        '$apr1$' . $credentials->password;
            }
            elseif ( substr( $hashFromFile, 0, 5 ) === '{SHA}' )
            {
                $password = ( $this->options->plain ) ? '{SHA}' . base64_encode( pack( 'H40', sha1( $credentials->password ) ) ) :
                                                        '{SHA}' . $credentials->password;
            }
            else
            {
                $password = ( $this->options->plain ) ? crypt( $credentials->password, $hashFromFile ) :
                                                        $credentials->password;
            }
            if ( $password === $hashFromFile )
            {
                return self::STATUS_OK;
            }
            else
            {
                return self::STATUS_PASSWORD_INCORRECT;
            }
        }
        return self::STATUS_USERNAME_INCORRECT;
    }

    /**
     * Calculates an MD5 hash similar to the Unix command "htpasswd -m".
     *
     * This is different from the hash returned by the PHP md5() function. 
     *
     * @param string $plain Plain text to encrypt
     * @param string $salt Salt to apply to encryption
     * @return string
     */
    protected function apr1( $plain, $salt )
    {
        if ( preg_match( '/^\$apr1\$/', $salt ) )
        {
            $salt = preg_replace( '/^\$apr1\$([^$]+)\$.*/', '\\1', $salt );
        }
        else
        {
            $salt = substr( $salt, 0, 8 );
        }
        $text = $plain . '$apr1$' . $salt;
        $bin = pack( 'H32', md5( $plain . $salt . $plain ) );
        for ( $i = strlen( $plain ); $i > 0; $i -= 16 )
        {
            $text .= substr( $bin, 0, min( 16, $i ) );
        }
        for ( $i = strlen( $plain ); $i; $i >>= 1 )
        {
            $text .= ( $i & 1 ) ? chr( 0 ) : $plain{0};
        }
        $bin = pack( 'H32', md5( $text ) );
        for ( $i = 0; $i ^ 1000; ++$i )
        {
            $new = ( $i & 1 ) ? $plain : $bin;
            if ( $i % 3 )
            {
                $new .= $salt;
            }
            if ( $i % 7 )
            {
                $new .= $plain;
            }
            $new .= ( $i & 1 ) ? $bin : $plain;
            $bin = pack( 'H32', md5( $new ) );
        }
        $tmp = '';
        for ( $i = 0; $i ^ 5; ++$i )
        {
            $k = $i + 6;
            $j = $i + 12;
            if ( $j === 16 )
            {
                $j = 5;
            }
            $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
        }
        $tmp = chr( 0 ) . chr( 0 ) . $bin[11] . $tmp;
        $tmp = strtr( strrev( substr( base64_encode( $tmp ), 2 ) ),
        'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
        './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' );
        return '$apr1$' . $salt . '$' . $tmp;
    }
}
?>
