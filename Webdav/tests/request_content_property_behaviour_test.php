<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavRequestPropertyBehaviourContentTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavRequestPropertyBehaviourContent';
        $this->defaultValues = array(
            'keepAlive' => null,
            'omit'      => false,
        );
        $this->workingValues = array(
            'keepAlive' => array(
                array( 'http://example.com', 'http://example.com/test' ),
                ezcWebdavRequestPropertyBehaviourContent::ALL,
                null,
            ),
            'omit' => array(
                true,
                false,
            ),
        );
        $this->failingValues = array(
            'keepAlive' => array(
                23,
                23.34,
                'foo',
                true,
                false,
                new stdClass(),
            ),
            'omit' => array(
                23,
                23.34,
                'foo',
                new stdClass(),
                array( 23, 42 ),
            ),
        );
    }

    public function testCtorSuccess()
    {
        $class = new ReflectionClass( $this->className );
        $object = $class->newInstance();
        $this->assertPropertyValues( $object, $this->defaultValues );
    }
}

?>
