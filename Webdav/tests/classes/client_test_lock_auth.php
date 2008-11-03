<?php

class ezcWebdavClientTestRfcLockAuth 
    extends ezcWebdavDigestAuthenticatorBase
    implements ezcWebdavAuthorizer, ezcWebdavLockAuthorizer
{
    public $tokenAssignement = array();

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

    public function assignLock( $user, $lockToken )
    {
        if ( !isset( $this->tokenAssignement[$user] ) )
        {
            $this->tokenAssignement[$user] = array();
        }
        $this->tokenAssignement[$user][$lockToken] = true;
    }

    public function ownsLock( $user, $lockToken )
    {
        return (
            isset( $this->tokenAssignement[$user] )
            && isset( $this->tokenAssignement[$user][$lockToken] )
        );
    }

    public function releaseLock( $user, $lockToken )
    {
        unset( $this->tokenAssignement[$user][$lockToken] );
    }
}

?>
