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
class ezcTemplateDirectResourceLocatorTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateDirectResourceLocatorTest" );
    }

    /**
     * Try to find templates using direct resource locator. The returned data
     * should contain the same path as you requested.
     */
    public function testFindSource()
    {
        $resources = array( '',
                            'pagelayout.tpl',
                            'zlib:pagelayout.tpl.gzip',
                            'templates/pagelayout.tpl' );
        $locations = array( new ezcTemplateSourceCode( '', '' ),
                            new ezcTemplateSourceCode( 'pagelayout.tpl', 'pagelayout.tpl' ),
                            new ezcTemplateSourceCode( 'zlib:pagelayout.tpl.gzip', 'zlib:pagelayout.tpl.gzip' ),
                            new ezcTemplateSourceCode( 'templates/pagelayout.tpl', 'templates/pagelayout.tpl' ) );
        $locator = new ezcTemplateDirectResourceLocator();
        foreach( $resources as $key => $resource )
        {
            $source = $locator->findSource( $resource );
            $source->resource = $resource;
            self::assertSame( 'ezcTemplateSourceCode', get_class( $source ),
                              'findSource(<' . $resource . '>) did not return the correct object.' );
            self::assertSame( $locations[$key]->stream, $source->stream,
                              'Property <stream> does not match expected value for resource <' . $resource . '>.' );
            self::assertSame( $locations[$key]->resource, $source->resource,
                              'Property <resource> does not match expected value for resource <' . $resource . '>.' );
        }
    }
}

?>
