<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavGetContentLanguagePropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetContentLanguageProperty';
        $this->defaultValues = array(
            'languages' => array(),
        );
        $this->workingValues = array(
            'languages' => array(
                array(),
                array( 'en' ),
                array( 'en', 'de', 'no', 'nl' ),
            ),
        );
        $this->failingValues = array(
            'languages' => array(
                null,
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
