<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavGetContentLengthPropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetContentLengthProperty';
        $this->defaultValues = array(
            'length' => null,
        );
        $this->workingValues = array(
            'length' => array(
                null,
                "1234",
                // 2 GB + 1b
                "2147483649"
            ),
        );
        $this->failingValues = array(
            'length' => array(
                // No negative filesizes
                '-23',
                // No filesize with part bytes
                '23.42',
                'foo',
                23,
                23.34,
                true,
                false,
                new stdClass(),
            ),
        );
    }
}

?>
