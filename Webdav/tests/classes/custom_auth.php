<?php

class ezcWebdavTestAuth implements ezcWebdavAuth
{

    private $permissions = array(
        'a' => array(
            'foo'  => ezcWebdavAuth::ACCESS_READ,
            'some' => ezcWebdavAuth::ACCESS_WRITE,
        ),
        'b' => array(
            'foo'  => ezcWebdavAuth::ACCESS_WRITE,
            'some' => ezcWebdavAuth::ACCESS_WRITE,
            ''     => ezcWebdavAuth::ACCESS_WRITE,
        ),
        'c' => array(
            'foo'  => ezcWebdavAuth::ACCESS_READ,
            'some' => ezcWebdavAuth::ACCESS_READ,
            ''     => ezcWebdavAuth::ACCESS_READ,
        ),
    );

    public function authenticate( $user, $pass )
    {
        switch ( true )
        {
            case ( $user === 'foo' && $pass === 'bar' ):
            case ( $user === 'some' && $pass === 'thing' ):
            case ( $user === '23' && $pass === '42' ):
            case ( $user === '' && $pass === '' ):
                return true;

            default:
                return false;
        }
    }

    public function authorize( $user, $path, $access = ezcWebdavAuth::ACCESS_READ )
    {
        $basedir = substr( $path, 1, 1 );
        return ( isset( $this->permissions[$basedir][$user] ) && $this->permissions[$basedir][$user] >= $access );
    }
}

?>
