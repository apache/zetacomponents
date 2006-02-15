<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateResourceLocatorTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateResourceLocatorTest" );
    }

    /**
     * Parse various resource strings and check for correct locator and location values.
     */
    public function testParseLocationString()
    {
        $resources = array( '',
                            'pagelayout.tpl',
                            'file:pagelayout.tpl',
                            'file::pagelayout.tpl',
                            'design:pagelayout.tpl',
                            'design:layout:page.tpl',
                            'design:zlib:pagelayout.tpl.gzip',
                            'design:templates/pagelayout.tpl' );
        $locations = array( new ezcTemplateLocation( false, '' ),
                            new ezcTemplateLocation( false, 'pagelayout.tpl' ),
                            new ezcTemplateLocation( 'file', 'pagelayout.tpl' ),
                            new ezcTemplateLocation( 'file', ':pagelayout.tpl' ),
                            new ezcTemplateLocation( 'design', 'pagelayout.tpl' ),
                            new ezcTemplateLocation( 'design', 'layout:page.tpl' ),
                            new ezcTemplateLocation( 'design', 'zlib:pagelayout.tpl.gzip' ),
                            new ezcTemplateLocation( 'design', 'templates/pagelayout.tpl' ) );
        foreach( $resources as $key => $resource )
        {
            $location = ezcTemplateResourceLocator::parseLocationString( $resource );
            self::assertSame( 'ezcTemplateLocation', get_class( $location ),
                              'parseLocationString(<' . $resource . '>) did not return the correct object.' );
            self::assertSame( $locations[$key]->locator, $location->locator,
                              'Property <locator> does not match expected value for resource <' . $resource . '>.' );
            self::assertSame( $locations[$key]->stream, $location->stream,
                              'Property <stream> does not match expected value for resource <' . $resource . '>.' );
        }
    }
}

?>
