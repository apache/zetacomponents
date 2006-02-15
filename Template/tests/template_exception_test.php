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

class ezcTemplateExceptionTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateExceptionTest" );
    }

    /**
     * Test 'locator not found' constructor values
     */
    public function testLocatorNotFound()
    {
        $e = new ezcTemplateLocatorNotFoundException( new ezcTemplateLocation( 'design', 'some/place/nice.tpl' ) );

        self::assertSame( "The requested template location <design:some/place/nice.tpl> could not be processed, the locator <design> was not found in the manager.", $e->getMessage(),
                          'Exception message is not correct' );
    }
}

?>
