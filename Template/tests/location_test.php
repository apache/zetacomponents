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
class ezcTemplateLocationTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateLocationTest" );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $location = new ezcTemplateLocation( "planet", "Z'ha'dum" );

        self::assertSame( "planet", $location->locator, 'Property <locator> does not return correct value.' );
        self::assertSame( "Z'ha'dum", $location->stream, 'Property <stream> does not return correct value.' );
    }
}

?>
