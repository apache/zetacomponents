<?php

class ezcWebdavTestAuth extends ezcWebdavDigestAuthenticatorBase implements ezcWebdavAuthorizer
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

    private $credentials = array(
        'foo'    => 'bar',
        'some'   => 'thing',
        '23'     => '42',
        ''       => '',
        'Mufasa' => 'Circle Of Life',
    );

    public function authenticateBasic( ezcWebdavBasicAuth $data )
    {
        return ( isset( $this->credentials[$data->username] ) && $this->credentials[$data->username] === $data->password );
    }

    public function authenticateDigest( ezcWebdavDigestAuth $data )
    {
        return ( isset( $this->credentials[$data->username] ) && $this->checkDigest( $data, $this->credentials[$data->username] ) );
    }

    public function authorize( $user, $path, $access = ezcWebdavAuthorizer::ACCESS_READ )
    {
        $basedir = substr( $path, 1, 1 );
        return ( isset( $this->permissions[$basedir][$user] ) && $this->permissions[$basedir][$user] >= $access );
    }
}

?>
