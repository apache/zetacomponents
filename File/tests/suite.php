<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package File
 * @subpackage Tests
 */

/**
 * Require the test cases
 */
require_once 'file_find_recursive_test.php';

/**
 * @package File
 * @subpackage Tests
 */
class ezcFileSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("File");

        $this->addTest( ezcFileFindRecursiveTest::suite() );
    }

    public static function suite()
    {
        return new ezcFileSuite();
    }
}
?>
