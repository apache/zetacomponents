<?php
/**
 * Autoloader definition for the Authentication component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Authentication
 */

return array(
    'ezcAuthenticationBignumLibrary'       => 'Authentication/math/bignum_library.php',
    'ezcAuthenticationCredentials'         => 'Authentication/credentials/credentials.php',
    'ezcAuthenticationException'           => 'Authentication/authentication/authentication_exception.php',
    'ezcAuthenticationFilter'              => 'Authentication/filters/authentication_filter.php',
    'ezcAuthenticationFilterOptions'       => 'Authentication/filters/filter_options.php',
    'ezcAuthenticationSession'             => 'Authentication/filters/session/authentication_session.php',
    'ezcAuthentication'                    => 'Authentication/authentication/authentication.php',
    'ezcAuthenticationBcmathLibrary'       => 'Authentication/math/bcmath_library.php',
    'ezcAuthenticationGmpLibrary'          => 'Authentication/math/gmp_library.php',
    'ezcAuthenticationGroupFilter'         => 'Authentication/filters/group/group_filter.php',
    'ezcAuthenticationGroupOptions'        => 'Authentication/filters/group/group_options.php',
    'ezcAuthenticationHtpasswdFilter'      => 'Authentication/filters/htpasswd/htpasswd_filter.php',
    'ezcAuthenticationHtpasswdOptions'     => 'Authentication/filters/htpasswd/htpasswd_options.php',
    'ezcAuthenticationIdCredentials'       => 'Authentication/credentials/id_credentials.php',
    'ezcAuthenticationLdapException'       => 'Authentication/filters/ldap/ldap_exception.php',
    'ezcAuthenticationLdapFilter'          => 'Authentication/filters/ldap/ldap_filter.php',
    'ezcAuthenticationLdapInfo'            => 'Authentication/filters/ldap/ldap_info.php',
    'ezcAuthenticationLdapOptions'         => 'Authentication/filters/ldap/ldap_options.php',
    'ezcAuthenticationMath'                => 'Authentication/math/math.php',
    'ezcAuthenticationOpenidException'     => 'Authentication/filters/openid/openid_exception.php',
    'ezcAuthenticationOpenidFilter'        => 'Authentication/filters/openid/openid_filter.php',
    'ezcAuthenticationOpenidOptions'       => 'Authentication/filters/openid/openid_options.php',
    'ezcAuthenticationOptions'             => 'Authentication/authentication/authentication_options.php',
    'ezcAuthenticationPasswordCredentials' => 'Authentication/credentials/password_credentials.php',
    'ezcAuthenticationSessionFilter'       => 'Authentication/filters/session/session_filter.php',
    'ezcAuthenticationSessionOptions'      => 'Authentication/filters/session/session_options.php',
    'ezcAuthenticationStatus'              => 'Authentication/status/authentication_status.php',
    'ezcAuthenticationTokenFilter'         => 'Authentication/filters/token/token_filter.php',
    'ezcAuthenticationTokenOptions'        => 'Authentication/filters/token/token_options.php',
    'ezcAuthenticationTypekeyException'    => 'Authentication/filters/typekey/typekey_exception.php',
    'ezcAuthenticationTypekeyFilter'       => 'Authentication/filters/typekey/typekey_filter.php',
    'ezcAuthenticationTypekeyOptions'      => 'Authentication/filters/typekey/typekey_options.php',
);
?>
