<?php
/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
class ezcWorkflowDatabaseTieinOptionsTest extends ezcTestCase
{
    protected $options;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowDatabaseTieinOptionsTest'
        );
    }

    protected function setUp()
    {
        $this->options = new ezcWorkflowDatabaseOptions;
    }

    public function testOptions()
    {
        $this->assertTrue( isset( $this->options['prefix'] ) );
        $this->assertEquals( '', $this->options['prefix'] );

        $this->options['prefix'] = 'myPrefix';
        $this->assertEquals( 'myPrefix', $this->options['prefix'] );
    }

    /**
     * @expectedException ezcBaseValueException
     */
    public function testOptions2()
    {
        $this->options['prefix'] = null;
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testOptions3()
    {
        $this->options['foo'] = 'bar';
    }
}
?>
