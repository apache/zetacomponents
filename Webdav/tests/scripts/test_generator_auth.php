<?php

class ezcWebdavClientTestGeneratorAuth implements ezcWebdavAuth
{
    public function authenticate( $user, $pass )
    {
        switch ( true )
        {
            case ( $user === '' && $pass === '' ):
            case ( $user === 'foo' && $pass === 'bar' ):
            case ( $user === 'some' && $pass === 'thing' ):
                return true;
            default:
                return false;
        }
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
