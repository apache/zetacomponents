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
            case ( $data->username === 'foo' && $data->password === 'bar' ):
            case ( $data->username === 'some' && $data->password === 'thing' ):
            case ( $data->username === '23' && $data->password === '42' ):
            case ( $data->username === '' && $data->password === '' ):
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
