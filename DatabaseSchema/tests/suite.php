<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

/**
 * Include schema conversion test.
 */
require_once 'conversion_test.php';

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaSuite extends ezcTestSuite
{
	public function __construct()
	{
        parent::__construct();
        $this->setName( 'DatabaseSchema' );

        $this->addTest( ezcDatabaseSchemaConversionTest::suite() );
	}

    public static function suite()
    {
        return new ezcDatabaseSchemaSuite();
    }
}

?>
