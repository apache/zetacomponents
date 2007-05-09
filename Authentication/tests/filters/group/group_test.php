<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationGroupTest extends ezcTestCase
{
    private static $path = null;
    private static $empty = null;
    
    public static function suite()
    {
        self::$path = dirname( __FILE__ ) . '/../htpasswd/data/htpasswd';
        self::$empty = dirname( __FILE__ ) . '/../htpasswd/data/htpasswd_empty';

        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationGroupTest" );
    }

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testGroupOrEmpty()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationGroupFilter( array() ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndEmpty()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationGroupFilter( array(), $optionsGroup ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupOrHtpasswdPass()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    )
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndHtpasswdPass()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupOrHtpasswFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wrong password' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    )
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupAndHtpasswFail()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wrong password' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupOrHtpasswdPassHtpasswdPass()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    )
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndHtpasswdPassHtpasswdPass()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupOrHtpasswdPassHtpasswdPassAddFilter()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $group = new ezcAuthenticationGroupFilter(
                    array(
                        new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                        )
                    );
        $group->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $authentication->addFilter( $group );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndHtpasswdPassHtpasswdPassAddFilter()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $group = new ezcAuthenticationGroupFilter(
                    array(
                        new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                        ), $optionsGroup
                    );
        $group->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $authentication->addFilter( $group );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupOrHtpasswdPassHtpasswdFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options )
                    )
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndHtpasswdPassHtpasswdFail()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupOrHtpasswdFailHtpasswdPass()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    )
                )
            );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGroupAndHtpasswdFailHtpasswdPass()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$path, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupOrHtpasswdFailHtpasswdFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options )
                    )
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupAndHtpasswdFailHtpasswdFail()
    {
        $optionsGroup = new ezcAuthenticationGroupOptions();
        $optionsGroup->mode = ezcAuthenticationGroupFilter::MODE_AND;
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter(
            new ezcAuthenticationGroupFilter(
                array(
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options ),
                    new ezcAuthenticationHtpasswdFilter( self::$empty, $options )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testOptions()
    {
        $options = new ezcAuthenticationGroupOptions();

        try
        {
            $options->mode = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'mode' is invalid. Allowed values are: 1, 2.", $e->getMessage() );
        }

        try
        {
            $options->mode = '1';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '1' that you were trying to assign to setting 'mode' is invalid. Allowed values are: 1, 2.", $e->getMessage() );
        }

        try
        {
            $options->mode = 1000;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '1000' that you were trying to assign to setting 'mode' is invalid. Allowed values are: 1, 2.", $e->getMessage() );
        }

        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $filter = new ezcAuthenticationGroupFilter( array() );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testProperties()
    {
        $filter = new ezcAuthenticationGroupFilter( array() );
        $this->assertEquals( true, isset( $filter->status ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->status = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'status' is invalid. Allowed values are: ezcAuthenticationStatus.", $e->getMessage() );
        }

        try
        {
            $filter->no_such_property = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }

        try
        {
            $value = $filter->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }
}
?>
