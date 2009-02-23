<?php
/**
 * ezcTreeVisitorXHTMLOptionsTest
 * 
 * @package Tree
 * @version //autogentag//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcTreeVisitorOptions class.
 * 
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeVisitorXHTMLOptionsTest extends ezcTestCase
{
    public function testDefaultSettings()
    {
        $options = new ezcTreeVisitorXHTMLOptions;

        self::assertSame( '', $options->basePath );
        self::assertSame( true, $options->addLinks );
        self::assertSame( false, $options->displayRootNode );
        self::assertSame( null, $options->xmlId );
        self::assertSame( array(), $options->highlightNodeIds );
        self::assertSame( array(), $options->subtreeHighlightNodeIds );
        self::assertSame( false, $options->selectedNodeLink );
    }

    public function testGetUnknownProperty()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $dummy = $options->unknown;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testSetValidOptionValues1()
    {
        $options = new ezcTreeVisitorXHTMLOptions;

        $options->basePath = '/view';
        $options->addLinks = false;
        $options->displayRootNode = true;
        $options->xmlId = 'menu_tree';
        $options->highlightNodeIds = array( 'root' );
        $options->subtreeHighlightNodeIds = array( 'root' );
        $options->selectedNodeLink = true;

        self::assertSame( '/view', $options->basePath );
        self::assertSame( false, $options->addLinks );
        self::assertSame( true, $options->displayRootNode );
        self::assertSame( 'menu_tree', $options->xmlId );
        self::assertSame( array( 'root' ), $options->highlightNodeIds );
        self::assertSame( array( 'root' ), $options->subtreeHighlightNodeIds );
        self::assertSame( true, $options->selectedNodeLink );
    }

    public function testSetValidOptionValues2()
    {
        $optionsArray = array();
        $optionsArray['basePath'] = '/view';
        $optionsArray['addLinks'] = false;
        $optionsArray['displayRootNode'] = true;
        $optionsArray['xmlId'] = 'menu_tree';
        $optionsArray['highlightNodeIds'] = array( 'root' );
        $optionsArray['subtreeHighlightNodeIds'] = array( 'root' );
        $optionsArray['selectedNodeLink'] = true;

        $options = new ezcTreeVisitorXHTMLOptions( $optionsArray );

        self::assertSame( '/view', $options->basePath );
        self::assertSame( false, $options->addLinks );
        self::assertSame( true, $options->displayRootNode );
        self::assertSame( 'menu_tree', $options->xmlId );
        self::assertSame( array( 'root' ), $options->highlightNodeIds );
        self::assertSame( array( 'root' ), $options->subtreeHighlightNodeIds );
        self::assertSame( true, $options->selectedNodeLink );
    }

    public function testSetInvalidBasePath()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->basePath = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'basePath' is invalid. Allowed values are: string.", $e->getMessage() );
        }
    }

    public function testSetInvalidAddLinks()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->addLinks = "no";
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value 'no' that you were trying to assign to setting 'addLinks' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testSetInvalidDisplayRootNode()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->displayRootNode = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'displayRootNode' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testSetInvalidSelectedNodeLink()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->selectedNodeLink = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'selectedNodeLink' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testSetInvalidXmlId()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->xmlId = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'xmlId' is invalid. Allowed values are: null or string.", $e->getMessage() );
        }
    }

    public function testSetInvalidHighlightNodes()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->highlightNodeIds = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'highlightNodeIds' is invalid. Allowed values are: array(string).", $e->getMessage() );
        }
    }

    public function testSetInvalidSubtreeHighlightNodes()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->subtreeHighlightNodeIds = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'subtreeHighlightNodeIds' is invalid. Allowed values are: array(string).", $e->getMessage() );
        }
    }

    public function testSetUnknownProperty()
    {
        $options = new ezcTreeVisitorXHTMLOptions;
        try
        {
            $options->unknown = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorXHTMLOptionsTest" );
    }
}
?>
