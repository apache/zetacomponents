<?php
/**
 * ezcCacheStackOptionsTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for the ezcCacheStackOptions class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackOptionsTest extends ezcTestCase
{
    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtorDefaultSuccess()
    {
        $opts = new ezcCacheStackOptions();
        $this->assertAttributeEquals(
            array(
                'configurator'        => null,
                'metaStorage'         => null,
                'replacementStrategy' => 'ezcCacheLruReplacementStrategy',
                'bubbleUpOnReplace'   => false,
            ),
            'properties',
            $opts,
            'Default options incorrect'
        );
    }
}



?>
