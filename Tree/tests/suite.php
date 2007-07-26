<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'tree.php';
require_once 'xml_tree.php';
require_once 'db_parent_child_tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Tree");

        $this->addTest( ezcTreeXmlTest::suite() );
        $this->addTest( ezcTreeDbParentChildTest::suite() );
    }

    public static function suite()
    {
        return new ezcTreeSuite();
    }
}

?>
