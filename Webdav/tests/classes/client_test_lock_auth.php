<?php

class ezcWebdavClientTestRfcLockAuth extends ezcWebdavDigestAuthenticatorBase implements ezcWebdavAuthorizer
{
    public function authenticateBasic( ezcWebdavBasicAuth $auth )
    {
        return ( $auth->username === 'ejw' || $auth->username === '' );
    }

    public function authenticateDigest( ezcWebdavDigestAuth $auth )
    {
        return ( $auth->username === 'ejw' );
    }

    public function authorize( $user, $path, $access = ezcWebdavAuthorizer::ACCESS_READ )
    {
        if ( strpos( $path, '/webdav/secret' ) !== false )
        {
            return false;
        }
        return true;
    }
}

?>
