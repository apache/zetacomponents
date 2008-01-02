<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

/**
 * Wrapper used in the test suite.
 *
 * @package Debug
 * @subpackage Tests
 */
class MyFakeMapper implements ezcLogMapper
{
    public function get( $sev, $src, $cat )
    {
        return null;
    }
}
?>
