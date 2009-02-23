<?php
/**
 * @package GraphDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'dataset_pdo_test.php';

/**
 * @package GraphDatabaseTiein
 * @subpackage Tests
 */
class ezcGraphDatabaseTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'GraphDatabaseTiein' );

        $this->addTest( ezcGraphDatabaseTest::suite() );
    }

    public static function suite()
    {
        return new ezcGraphDatabaseTieinSuite;
    }
}
?>
