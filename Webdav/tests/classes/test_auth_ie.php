<?php

require_once 'test_auth.php';

class ezcWebdavTestAuthIe extends ezcWebdavTestAuth
{
    public function __construct()
    {
        $this->permissions = array(
            '' => array(
                'some' => ezcWebdavAuthorizer::ACCESS_WRITE,
            ),
            'collection' => array(
                'some' => ezcWebdavAuthorizer::ACCESS_WRITE,
            ),
        );
        $this->credentials = array(
            'foo'    => 'bar',
            'some'   => 'thing',
            '23'     => '42',
            ''       => '',
            'Mufasa' => 'Circle Of Life',
        );
    }
}

?>
