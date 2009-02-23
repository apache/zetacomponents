<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlTest extends ezcTestCase
{
    public function testPropertiesGet()
    {
        $url = new ezcUrl( 'http://user:password@www.example.com:82/index.php/content/view?products=10&mode=print#cat' );
        $this->assertEquals( 'http', $url->scheme );
        $this->assertEquals( 'www.example.com', $url->host );
        $this->assertEquals( 'user', $url->user );
        $this->assertEquals( 'password', $url->pass );
        $this->assertEquals( 82, $url->port );
        $this->assertEquals( array( 'index.php', 'content', 'view' ), $url->path );
        $this->assertEquals( array( 'products' => '10', 'mode' => 'print' ), $url->query );
        $this->assertEquals( 'cat', $url->fragment );
    }

    public function testPropertiesGetInvalid()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $url->no_such_property = 'data';
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $expected = "No such property name 'no_such_property'.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testPropertiesSet()
    {
        $url = new ezcUrl();
        $url->scheme = 'http';
        $url->user = 'user';
        $url->pass = 'pass';
        $url->host = 'www.example.com';
        $url->port = 82;
        $url->path = array( 'content', 'view' );
        $url->query = array( 'products' => 10, 'mode' => 'print' );
        $url->fragment = 'cat';
        $expected = "http://user:pass@www.example.com:82/content/view?products=10&mode=print#cat";
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testPropertiesSetInvalid()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $data = $url->no_such_property;
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $expected = "No such property name 'no_such_property'.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        try
        {
            $url->configuration = "value";
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'value' that you were trying to assign to setting 'configuration' is invalid. Allowed values are: instance of ezcUrlConfiguration.", $e->getMessage() );
        }
    }

    public function testConstructor()
    {
        $url = new ezcUrl( 'http://www.example.com/content/view/products/10/mode/print' );
        $expected = 'http://www.example.com/content/view/products/10/mode/print';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testBuildUrl()
    {
        $urlStrings = array();
        $urlStrings[] = 'http://www.example.com';
        $urlStrings[] = 'http://www.example.com/mydir/index.php';
        $urlStrings[] = 'http://www.example.com/mydir/index.php/other/stuff#cat';
        $urlStrings[] = 'http://www.example.com:82/mydir/index.php/other/stuff#cat';
        $urlStrings[] = 'http://user:password@www.example.com:82/mydir/index.php/other/stuff#cat';
        $urlStrings[] = 'http://user:password@www.example.com:82/mydir/index.php/other/stuff?me=you&arr[0]=yes&arr[1]=no#cat';

        // the dot would have been converted to underscore if using parse_str() to
        // parse the query part. ezcUrlTools::parseQueryString() is used instead
        $urlStrings[] = 'http://www.example.com/stuff?openid.nonce=123456';
        
        foreach ( $urlStrings as $urlString )
        {
            $url = new ezcUrl( $urlString );
            $this->assertEquals( $urlString, urldecode( $url->buildUrl() ) );
            $this->assertEquals( $urlString, urldecode( $url->__toString() ) );
        }
    }

    public function testBuildUrlWithBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = 'mydir/shop';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testIsRelativeFalse()
    {
        $url = new ezcUrl( 'http://www.example.com/blah/index.php' );
        $this->assertEquals( false, $url->isRelative() );
    }

    public function testIsRelativeTrue()
    {
        $url = new ezcUrl( 'blah/index.php'  );
        $this->assertEquals( true, $url->isRelative() );
    }

    public function testGetQuery()
    {
        $url = new ezcUrl( 'http://www.example.com/mydir/shop?content=view&products=10&mode=print' );
        $expected = array( 'content' => 'view', 'products' => '10', 'mode' => 'print' );
        $this->assertEquals( $expected, $url->getQuery() );
    }

    public function testGetQueryEmpty()
    {
        $url = new ezcUrl( 'http://www.example.com/mydir/shop' );
        $expected = array();
        $this->assertEquals( $expected, $url->getQuery() );
    }

    public function testSetQuery()
    {
        $url = new ezcUrl( 'http://www.example.com/mydir/shop' );
        $url->setQuery( array( 'content' => 'view', 'products' => '10', 'mode' => 'print' ) );
        $expected = 'http://www.example.com/mydir/shop?content=view&products=10&mode=print';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testGetOrderedParameter()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'branch' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk', $urlCfg );
        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'branch' ) );
    }

    public function testGetOrderedParameterEmpty()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'branch' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $this->assertEquals( null, $url->getParam( 'section' ) );
        $this->assertEquals( null, $url->getParam( 'module' ) );
        $this->assertEquals( null, $url->getParam( 'view' ) );
        $this->assertEquals( null, $url->getParam( 'branch' ) );
    }

    public function testGetOrderedParameterInvalid()
    {
        $urlCfg = new ezcUrlConfiguration();

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        try
        {
            $url->getParam( 'section' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'section' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testGetOrderedParameterNoCfg()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $url->getParam( 'section' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlNoConfigurationException $e )
        {
            $expected = "The parameter 'section' could not be set/get because the url doesn't have a configuration defined.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testSetOrderedParameter()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'branch' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/bugs/components/view/trunk';
        $url->setParam( 'section', 'bugs' );
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testSetOrderedParameterInvalid()
    {
        $urlCfg = new ezcUrlConfiguration();

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        try
        {
            $url->setParam( 'section', 'value' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'section' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testSetOrderedParameterNoCfg()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $url->setParam( 'section', 'doc' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlNoConfigurationException $e )
        {
            $expected = "The parameter 'section' could not be set/get because the url doesn't have a configuration defined.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testGetUnorderedParameterSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'file' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk/(file)/classtrees_Base.html', $urlCfg );
        $this->assertEquals( 'classtrees_Base.html', $url->getParam( 'file' ) );
    }

    public function testGetUnorderedParameterMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'file', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk/(file)/Base/ezcBase.html', $urlCfg );
        $this->assertEquals( array( 'Base', 'ezcBase.html' ), $url->getParam( 'file' ) );
    }

    public function testGetUnorderedParameterEmpty()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'file' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk/(file)', $urlCfg );
        $this->assertEquals( null, $url->getParam( 'file' ) );
    }

    public function testGetUnorderedParameterInvalid()
    {
        $urlCfg = new ezcUrlConfiguration();

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        try
        {
            $url->getParam( 'file' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'file' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testGetUnorderedParameterNoCfg()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $url->getParam( 'file' );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlNoConfigurationException $e )
        {
            $expected = "The parameter 'file' could not be set/get because the url doesn't have a configuration defined.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testSetUnorderedParameterSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'file' );
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(file)/Base';
        $url->setParam( 'file', 'Base' );
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testSetUnorderedParameterMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'file', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(file)/Base/ezcBase.html';
        $url->setParam( 'file', array( 'Base', 'ezcBase.html' ) );
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testSetUnorderedParameterInvalid()
    {
        $urlCfg = new ezcUrlConfiguration();

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        try
        {
            $url->setParam( 'file', array( 'Base', 'ezcBase.html' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'file' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testSetUnorderedParameterNoCfg()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        try
        {
            $url->setParam( 'file', array( 'Base', 'ezcBase.html' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlNoConfigurationException $e )
        {
            $expected = "The parameter 'file' could not be set/get because the url doesn't have a configuration defined.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testRemoveOrderedParameter()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );

        $url = new ezcUrl( 'http://www.example.com/doc/components', $urlCfg );
        $this->assertEquals( array( 'section' => 0, 'module' => 1, 'view' => 2 ), $url->configuration->orderedParameters );
        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );

        $url->configuration->removeOrderedParameter( 'view' );
        $this->assertEquals( array( 'section' => 0, 'module' => 1 ), $url->configuration->orderedParameters );

        try
        {
            $this->assertEquals( null, $url->getParam( 'view' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'view' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        // try removing again - nothing bad should happen
        $url->configuration->removeOrderedParameter( 'view' );
        try
        {
            $this->assertEquals( null, $url->getParam( 'view' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'view' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testRemoveUnorderedParameter()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addUnorderedParameter( 'file', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );    

        $url = new ezcUrl( 'http://www.example.com/doc/components/(file)/Base/ezcBase.html', $urlCfg );
        $this->assertEquals( array( 'file' => 2 ), $url->configuration->unorderedParameters );
        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( array( 'Base', 'ezcBase.html' ), $url->getParam( 'file' ) );

        $url->configuration->removeUnorderedParameter( 'file' );
        $this->assertEquals( array(), $url->configuration->unorderedParameters );

        try
        {
            $this->assertEquals( null, $url->getParam( 'file' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'file' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        // try removing again - nothing bad should happen
        $url->configuration->removeUnorderedParameter( 'file' );
        try
        {
            $this->assertEquals( null, $url->getParam( 'file' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcUrlInvalidParameterException $e )
        {
            $expected = "The parameter 'file' could not be set/get because it is not defined in the configuration.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testBuildUrlWithBasedirAppendedSlash()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = 'mydir/shop/';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testBuildUrlWithAbsoluteBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testBuildUrlWithAbsoluteBasedirAppendedSlash()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop/';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl() );
    }

    public function testGetOrderedParameterBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = 'mydir/';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'branch' );

        $url = new ezcUrl( 'http://www.example.com/mydir/index.php/doc/components/view/trunk', $urlCfg );
        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'branch' ) );
    }

    public function testGetOrderedParameterAbsoluteBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'branch' );

        $url = new ezcUrl( 'http://www.example.com/mydir/index.php/doc/components/view/trunk', $urlCfg );
        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'branch' ) );
    }

    public function testBuildUrlWithScriptName()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/index.php/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl( true ) );
    }

    public function testBuildUrlWithScriptNameWithoutBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/index.php/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/index.php/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl( true ) );
    }

    public function testBuildUrlWithScriptNameMissingScript()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/doc/components/view/trunk', $urlCfg );
        $expected = 'http://www.example.com/mydir/shop/doc/components/view/trunk';
        $this->assertEquals( $expected, $url->buildUrl( true ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::SINGLE_ARGUMENT );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/y';
        //$this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( 'y', $url->getParam( 'param2' ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y/z", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y/z';
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( array( 'y', 'z' ), $url->getParam( 'param2' ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeMultipleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y';
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( array( 'y' ), $url->getParam( 'param2' ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeAggregateSingleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y/z", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y/z';
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( array( array( 'x' ), array( 'y', 'z' ) ), $url->getParam( 'param2' ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeAggregateSingleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/(param2)/y';
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( array( array( 'x' ), array( 'y' ) ), $url->getParam( 'param2' ) );
    }

    public function testGetUnorderedParametersMultipleValuesTypeAggregateMultipleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'section' );
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addOrderedParameter( 'view' );
        $urlCfg->addOrderedParameter( 'content' );
        $urlCfg->addUnorderedParameter( 'param1' );
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( "http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/y/(param2)/z", $urlCfg );
        $expected = 'http://www.example.com/doc/components/view/trunk/(param1)/a/(param2)/x/y/(param2)/z';
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'doc', $url->getParam( 'section' ) );
        $this->assertEquals( 'components', $url->getParam( 'module' ) );
        $this->assertEquals( 'view', $url->getParam( 'view' ) );
        $this->assertEquals( 'trunk', $url->getParam( 'content' ) );
        $this->assertEquals( 'a', $url->getParam( 'param1' ) );
        $this->assertEquals( array( array( 'x', 'y' ), array( 'z' ) ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterSingleArraySingleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'y', $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterSingleArraySingleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y/z';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y', 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'y', $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterSingleArrayMultipleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'z', $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterSingleArrayMultipleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z/t';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z', 't' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( 'z', $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterMultipleArraySingleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( 'y' ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterMultipleArraySingleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y/z';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y', 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( 'y', 'z' ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterMultipleArrayMultipleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( 'z' ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterMultipleArrayMultipleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z/t';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z', 't' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( 'z', 't' ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterAggregateArraySingleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( array( 'x' ), array( 'y' ) ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterAggregateArraySingleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/(param2)/y/z';

        $url->setParam( 'param2', array( array( 'x' ), array( 'y', 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( array( 'x' ), array( 'y', 'z' ) ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterAggregateArrayMultipleSingle()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( array( 'x', 'y' ), array( 'z' ) ), $url->getParam( 'param2' ) );
    }

    public function testSetUnorderedParameterAggregateArrayMultipleMultiple()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addUnorderedParameter( 'param2', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );
        $expected = 'http://www.example.com/(param2)/x/y/(param2)/z/t';

        $url->setParam( 'param2', array( array( 'x', 'y' ), array( 'z', 't' ) ) );
        $this->assertEquals( $expected, $url->buildUrl() );

        $this->assertEquals( array( array( 'x', 'y' ), array( 'z', 't' ) ), $url->getParam( 'param2' ) );
    }

    public function testSetOrderedParameterArrayFail()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'param2' );

        $url = new ezcUrl( 'http://www.example.com', $urlCfg );

        try
        {
            $url->setParam( 'param2', array( 'x' ) );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'a:1:{i:0;s:1:\"x\";}' that you were trying to assign to setting 'param2' is invalid. Allowed values are: string.", $e->getMessage() );
        }
    }

    public function testGetUnorderedParametersUnknownNoOrdered()
    {
        $urlCfg = new ezcUrlConfiguration();

        $url = new ezcUrl( 'http://www.example.com/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
    }

    public function testGetUnorderedParametersUnknownBasedir()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
    }

    public function testGetUnorderedParametersUnknownScript()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->script = 'index.php';

        $url = new ezcUrl( 'http://www.example.com/index.php/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
    }

    public function testGetUnorderedParametersUnknownBasedirScript()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->script = 'index.php';

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
    }

    public function testGetUnorderedParametersUnknownOrdered()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->addOrderedParameter( 'module' );

        $url = new ezcUrl( 'http://www.example.com/order/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
    }

    public function testGetUnorderedParametersUnknownBasedirScriptOrdered()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'module' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/order/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( 'order', $url->getParam( 'module' ) );
        $this->assertEquals( array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
        $this->assertEquals( 'order', $url->getParam( 'module' ) );
    }

    public function testGetUnorderedParametersUnknownBasedirScriptOrderedUnordered()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = '/mydir/shop';
        $urlCfg->script = 'index.php';
        $urlCfg->addOrderedParameter( 'module' );
        $urlCfg->addUnorderedParameter( 'Software' );

        $url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/order/(Software)/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );
        $this->assertEquals( 'order', $url->getParam( 'module' ) );
        $this->assertEquals( 'PHP', $url->getParam( 'Software' ) );
        $this->assertEquals( array( '(Software)', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' ), $url->getParams() );
        $this->assertEquals( 'PHP', $url->getParam( 'Software' ) );
        $this->assertEquals( 'order', $url->getParam( 'module' ) );
    }

    /**
     * Test for bug #12825 (URL parser doesn't like empty elements.)
     */
    public function testGetUnorderedParameterMissing()
    {
        $urlCfg = new ezcUrlConfiguration();
        $urlCfg->basedir = 'mydir/';
        $urlCfg->script = 'index.php';
        $urlCfg->addUnorderedParameter( 'language' );

        // should have been http://www.example.com/mydir/index.php/(language)/en
        $url = new ezcUrl( 'http://www.example.com/mydir/index.php//en', $urlCfg );
        $this->assertEquals( null, $url->getParam( 'language' ) );
    }

    public function testIsSet()
    {
        $url = new ezcUrl( 'http://www.example.com' );
        $this->assertEquals( true, isset( $url->host ) );
        $this->assertEquals( false, isset( $url->user ) );
        $this->assertEquals( false, isset( $url->pass ) );
        $this->assertEquals( false, isset( $url->port ) );
        $this->assertEquals( true, isset( $url->scheme ) );
        $this->assertEquals( false, isset( $url->fragment ) );
        $this->assertEquals( true, isset( $url->path ) );
        $this->assertEquals( true, isset( $url->basedir ) );
        $this->assertEquals( true, isset( $url->script ) );
        $this->assertEquals( true, isset( $url->params ) );
        $this->assertEquals( true, isset( $url->uparams ) );
        $this->assertEquals( true, isset( $url->query ) );
        $this->assertEquals( false, isset( $url->configuration ) );
        $this->assertEquals( false, isset( $url->no_such_property ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcUrlTest" );
    }
}
?>
