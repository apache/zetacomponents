<?php

class ezcWebdavClientTestGeneratorAuth implements ezcWebdavBasicAuthenticator, ezcWebdavDigestAuthenticator, ezcWebdavAuthorizer
{
    public function authenticateBasic( ezcWebdavBasicAuth $data )
    {
        switch ( true )
        {
            case ( $data->username === '' && $data->password === '' ):
            case ( $data->username === 'foo' && $data->password === 'bar' ):
            case ( $data->username === 'some' && $data->password === 'thing' ):
                return true;
            default:
                return false;
        }
    }

    public function authenticateDigest( ezcWebdavDigestAuth $data )
    {
        // @todo: Implement!
        return true;
    }

    public function authorize( $user, $path, $access = self::ACCESS_READ )
    {
        if ( substr( $path, 0, 18 ) !== '/secure_collection' )
        {
            return true;
        }
        switch ( $user )
        {
            case 'foo':
                return ( $access === self::ACCESS_READ );
            case 'some':
                return true;
            default:
                return false;
        }

    }
}

?>
