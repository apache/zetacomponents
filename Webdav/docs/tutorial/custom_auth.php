<?php

class myCustomAuth extends ezcWebdavDigestAuthenticatorBase
                   implements ezcWebdavAuthorizer
{
    protected $credentials = array(
        'some' => 'thing',
    );

    public function authenticateAnonymous( ezcWebdavAnonymousAuth $data )
    {
        return true;
    }

    public function authenticateBasic( ezcWebdavBasicAuth $data )
    {
        $username = $data->username;
        $password = $data->password;

        if ( !isset( $this->credentials[$username] ) )
        {
            return false;
        }
        return ( $this->credentials[$username] === $password );
    }

    public function authenticateDigest( ezcWebdavDigestAuth $data )
    {
        $username = $data->username;

        if ( !isset( $this->credentials[$username] ) )
        {
            return false;
        }
        return ( $this->checkDigest( $data, $this->credentials[$username] ) );
    }

    public function authorize( $user, $path, $access = ezcWebdavAuthorizer::ACCESS_READ )
    {
        if ( $access = ezcWebdavAuthorizer::ACCESS_READ )
        {
            return true;
        }
        if ( $user === 'some' && substr( $path, 0, 5 ) === '/some' )
        {
            return true;
        }
        return false;
    }
}

?>
