<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavSourcePropertyLinkTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSourcePropertyLink';
        $this->defaultValues = array(
            'src' => null,
            'dst' => null,
        );
        $this->workingValues = array(
            'src' => array(
                null,
                '',
                'foobar',
            ),
            'dst' => array(
                null,
                '',
                'foobar',
            ),
        );
        $this->failingValues = array(
            'src' => array(
                23,
                23.34,
                true,
                false,
                new stdClass(),
                array(),
            ),
            'dst' => array(
                23,
                23.34,
                true,
                false,
                new stdClass(),
                array(),
            ),
        );
    }
}

?>
