<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

/**
 * Test formatter used in the test suite.
 *
 * @package Debug
 * @subpackage Tests
 */
class TestReporter implements ezcDebugOutputFormatter
{
	public function generateOutput( array $timerData, array $writerData )
	{
        return array( $timerData, $writerData );
	}
}
?>
