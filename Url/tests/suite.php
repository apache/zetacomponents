<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "url_test.php" );

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Url");

        $this->addTest( ezcUrlTest::suite() );
    }

    public static function suite()
    {
        return new ezcUrlSuite();
    }
}
?>
