<?php
/**
 * Autoloader definition for the ezcAuthentication component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

return array(

    // authentication class
    'ezcAuthentication'                       => 'Authentication/authentication.php',

    // authentication credentials
    'ezcAuthenticationCredentials'            => 'Authentication/credentials/credentials.php',
    'ezcAuthenticationIdCredentials'          => 'Authentication/credentials/id_credentials.php',
    'ezcAuthenticationPasswordCredentials'    => 'Authentication/credentials/password_credentials.php',

    // authentication exceptions
    'ezcAuthenticationException'              => 'Authentication/exceptions/authentication_exception.php',

    // authentication interfaces
    'ezcAuthenticationFilter'                 => 'Authentication/interfaces/authentication_filter.php',
    'ezcAuthenticationSession'                => 'Authentication/interfaces/authentication_session.php',
    'ezcAuthenticationStatus'                 => 'Authentication/interfaces/authentication_status.php',

    // authentication options
    'ezcAuthenticationOptions'                => 'Authentication/options/authentication_options.php',
    'ezcAuthenticationFilterOptions'          => 'Authentication/options/filter_options.php',

    // authentication Group filter
    'ezcAuthenticationGroupFilter'            => 'Authentication/filters/group/group_filter.php',
    'ezcAuthenticationGroupOptions'           => 'Authentication/filters/group/group_options.php',

    // authentication Htpasswd filter
    'ezcAuthenticationHtpasswdFilter'         => 'Authentication/filters/htpasswd/htpasswd_filter.php',
    'ezcAuthenticationHtpasswdOptions'        => 'Authentication/filters/htpasswd/htpasswd_options.php',

    // authentication LDAP filter
    'ezcAuthenticationLdapFilter'             => 'Authentication/filters/ldap/ldap_filter.php',
    'ezcAuthenticationLdapException'          => 'Authentication/filters/ldap/ldap_exception.php',
    'ezcAuthenticationLdapInfo'               => 'Authentication/filters/ldap/ldap_info.php',
    'ezcAuthenticationLdapOptions'            => 'Authentication/filters/ldap/ldap_options.php',

    // authentication Session filter
    'ezcAuthenticationSessionFilter'          => 'Authentication/filters/session/session_filter.php',
    'ezcAuthenticationSessionOptions'         => 'Authentication/filters/session/session_options.php',

    // authentication Token filter
    'ezcAuthenticationTokenFilter'            => 'Authentication/filters/token/token_filter.php',
    'ezcAuthenticationTokenOptions'           => 'Authentication/filters/token/token_options.php',

    // authentication TypeKey filter
    'ezcAuthenticationTypekeyFilter'          => 'Authentication/filters/typekey/typekey_filter.php',
    'ezcAuthenticationTypekeyException'       => 'Authentication/filters/typekey/typekey_exception.php',
    'ezcAuthenticationTypekeyOptions'         => 'Authentication/filters/typekey/typekey_options.php',

    );
?>
