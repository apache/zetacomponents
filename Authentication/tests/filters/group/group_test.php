<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'Authentication/tests/test.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationGroupTest extends ezcAuthenticationTest
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

    public function testGroupConstructorArrayArrayFilters()
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
                    array( new ezcAuthenticationHtpasswdFilter( self::$empty, $options ) ),
                    array( new ezcAuthenticationHtpasswdFilter( self::$empty, $options ) )
                    ), $optionsGroup
                )
            );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testGroupOptions()
    {
        $options = new ezcAuthenticationGroupOptions();

        $this->invalidPropertyTest( $options, 'mode', 'wrong value', '1, 2' );
        $this->invalidPropertyTest( $options, 'mode', '1', '1, 2' );
        $this->invalidPropertyTest( $options, 'mode', 1000, '1, 2' );
        $this->invalidPropertyTest( $options, 'multipleCredentials', 'wrong value', 'bool' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testGroupOptionsGetSet()
    {
        $options = new ezcAuthenticationGroupOptions();

        $filter = new ezcAuthenticationGroupFilter( array() );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testGroupProperties()
    {
        $filter = new ezcAuthenticationGroupFilter( array() );

        $this->invalidPropertyTest( $filter, 'status', 'wrong value', 'ezcAuthenticationStatus' );
        $this->missingPropertyTest( $filter, 'no_such_property' );
    }

    public function testGroupPropertiesIsSet()
    {
        $filter = new ezcAuthenticationGroupFilter( array() );

        $this->issetPropertyTest( $filter, 'status', true );
        $this->issetPropertyTest( $filter, 'no_such_property', false );
    }
}
?>
