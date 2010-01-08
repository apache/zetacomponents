<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once 'template_mock_context.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateOutputContextTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateOutputContextTest" );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $context = new ezcTemplateMockContext;
    }
}

?>
