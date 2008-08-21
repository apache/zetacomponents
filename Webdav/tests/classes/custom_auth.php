<?php

class ezcWebdavTestAuth implements ezcWebdavBasicAuthenticator, ezcWebdavDigestAuthenticator, ezcWebdavAuthorizer
{

    private $permissions = array(
        'a' => array(
            'foo'  => ezcWebdavAuthorizer::ACCESS_READ,
            'some' => ezcWebdavAuthorizer::ACCESS_WRITE,
        ),
        'b' => array(
            'foo'  => ezcWebdavAuthorizer::ACCESS_WRITE,
            'some' => ezcWebdavAuthorizer::ACCESS_WRITE,
            ''     => ezcWebdavAuthorizer::ACCESS_WRITE,
        ),
        'c' => array(
            'foo'  => ezcWebdavAuthorizer::ACCESS_READ,
            'some' => ezcWebdavAuthorizer::ACCESS_READ,
            ''     => ezcWebdavAuthorizer::ACCESS_READ,
        ),
    );

    public function authenticateBasic( ezcWebdavBasicAuth $data )
    {
        switch ( true )
        {
            case ( $data->user === 'foo' && $data->pass === 'bar' ):
            case ( $data->user === 'some' && $data->pass === 'thing' ):
            case ( $data->user === '23' && $data->pass === '42' ):
            case ( $data->user === '' && $data->pass === '' ):
                return true;

            default:
                return false;
        }
    }

    public function authenticateDigest( ezcWebdavDigestAuth $data )
    {
        // @todo: Implement
        return true;
    }

    public function authorize( $user, $path, $access = ezcWebdavAuthorizer::ACCESS_READ )
    {
        $basedir = substr( $path, 1, 1 );
        return ( isset( $this->permissions[$basedir][$user] ) && $this->permissions[$basedir][$user] >= $access );
    }
}

?>
