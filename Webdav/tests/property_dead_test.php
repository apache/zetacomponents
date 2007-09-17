<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavDeadPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Get object of $className for testing.
     * 
     * @return stdClass
     */
    protected function getObject()
    {
        return new $this->className( 'namespace', 'name' );
    }

    public function testCtorSuccess()
    {
        return true;
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavDeadProperty';
        $this->propertyName = 'name';
        $this->namespace = 'namespace';
        $this->defaultValues = array(
            'content'    => null,
        );
        $this->workingValues = array(
            'content' => array(
                null,
                "foo bar",
                "",
            ),
        );
        $this->failingValues = array(
            'content' => array(
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
