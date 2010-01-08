<?php
/**
 * File containing the ezcAuthenticationTypekeyWrapper class.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Class which exposes the protected methods from the TypeKey filter.
 *
 * For testing purposes only.
 *
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationTypekeyWrapper extends ezcAuthenticationTypekeyFilter
{
    /**
     * Checks the information returned by the TypeKey server.
     *
     * @param string $msg Plain text signature which needs to be verified
     * @param string $r First part of the signature retrieved from TypeKey
     * @param string $s Second part of the signature retrieved from TypeKey
     * @param array(string=>string) $keys Public keys retrieved from TypeKey
     * @return bool
     */
    protected function checkSignature( $msg, $r, $s, $keys )
    {
        return parent::checkSignature( $msg, $r, $s, $keys );
    }

    /**
     * Fetches the public keys from the specified file or URL $file.
     *
     * The file must be composed of space-separated values for p, g, q, and
     * pub_key, like this:
     *   p=<value> g=<value> q=<value> pub_key=<value>
     *
     * The format of the returned array is:
     * <code>
     *   array( 'p' => p_val, 'g' => g_val, 'q' => q_val, 'pub_key' => pub_key_val )
     * </code>
     *
     * @throws ezcAuthenticationTypekeyException
     *         if the keys from the TypeKey public keys file could not be fetched
     * @return array(string=>string)
     */
    public function fetchPublicKeys( $file )
    {
        return parent::fetchPublicKeys( $file );
    }
}
?>
