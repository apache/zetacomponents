<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_options.php';

/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcBaseOptionsTest");
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcBaseTestOptions();
        try
        {
            echo $opt->properties;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on access to forbidden property \$properties" );
    }

    public function testGetOffsetAccessFailure()
    {
        $opt = new ezcBaseTestOptions();
        try
        {
            echo $opt["properties"];
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on access to forbidden property \$properties" );
    }

    public function testSetOffsetAccessFailure()
    {
        $opt = new ezcBaseTestOptions();
        try
        {
            $opt["properties"] = "foo";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on access to forbidden property \$properties" );
    }
}

?>
