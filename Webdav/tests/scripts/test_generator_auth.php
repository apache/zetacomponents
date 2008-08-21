<?php

class ezcWebdavClientTestGeneratorAuth implements ezcWebdavBasicAuthenticator, ezcWebdavDigestAuthenticator, ezcWebdavAuthorizer
{
    public function authenticateBasic( ezcWebdavBasicAuth $data )
    {
        switch ( true )
        {
            case ( $data->user === '' && $data->pass === '' ):
            case ( $data->user === 'foo' && $data->pass === 'bar' ):
            case ( $data->user === 'some' && $data->pass === 'thing' ):
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
