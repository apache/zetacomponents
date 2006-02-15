<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Http
 * @subpackage Tests
 */

/**
 * Include URL handling test.
 */
require_once 'url_test.php';

/**
 * @package Http
 * @subpackage Tests
 */
class ezcHttpSuite extends ezcTestSuite
{
	public function __construct()
	{
        parent::__construct();
        $this->setName( 'Http' );

        $this->addTest( ezcHttpUrlTest::suite() );
	}

    public static function suite()
    {
        return new ezcHttpSuite();
    }
}

?>
