<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
require_once 'file_remove_recursive_test.php';
require_once 'file_calculate_relative_path_test.php';

/**
 * @package File
 * @subpackage Tests
 */
class ezcFileSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("File");

        $this->addTest( ezcFileFindRecursiveTest::suite() );
        $this->addTest( ezcFileRemoveRecursiveTest::suite() );
        $this->addTest( ezcFileCalculateRelativePathTest::suite() );
    }

    public static function suite()
    {
        return new ezcFileSuite();
    }
}
?>
