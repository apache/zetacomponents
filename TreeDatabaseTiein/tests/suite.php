<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'Tree/tests/tree.php';
require_once 'db_materialized_path_tree.php';
require_once 'db_materialized_path_tree_diff_separator.php';
require_once 'db_nested_set_tree.php';
require_once 'db_parent_child_tree.php';
require_once 'copy_tree.php';
require_once 'xml_tree_db_storage.php';

/**
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */
class ezcTreeDatabaseTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("TreeDatabaseTiein");

        $this->addTest( ezcTreeDbMaterializedPathTest::suite() );
        $this->addTest( ezcTreeDbMaterializedPathTestWithDifferentSeparator::suite() );
        $this->addTest( ezcTreeDbNestedSetTest::suite() );
        $this->addTest( ezcTreeDbParentChildTest::suite() );
        $this->addTest( ezcTreeDbCopyTest::suite() );
        $this->addTest( ezcTreeXmlWithDbStorageTest::suite() );
    }

    public static function suite()
    {
        return new ezcTreeDatabaseTieinSuite();
    }
}

?>
