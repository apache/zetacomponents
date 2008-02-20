<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once 'handlers/solr_test.php';
require_once 'managers/xml_test.php';

/**
 * @package Search
 * @subpackage Tests
 */
class ezcSearchSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Search");

        $this->addTest( ezcSearchXmlDefinitionManager::suite() );
        $this->addTest( ezcSearchHandlerSolrTest::suite() );
    }

    public static function suite()
    {
        return new ezcSearchSuite();
    }
}

?>
