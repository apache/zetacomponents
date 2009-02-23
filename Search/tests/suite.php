<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require 'managers/embedded_test.php';
require 'managers/xml_test.php';
require 'handlers/solr_test.php';
require 'handlers/zend_lucene_test.php';
require 'build_query_test.php';
require 'session_test.php';

/**
 * @package Search
 * @subpackage Tests
 */
class ezcSearchSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Search' );

        $this->addTest( ezcSearchEmbeddedDefinitionManager::suite() );
        $this->addTest( ezcSearchXmlDefinitionManager::suite() );
        $this->addTest( ezcSearchBuildSearchQueryTest::suite() );
        $this->addTest( ezcSearchHandlerSolrTest::suite() );
        $this->addTest( ezcSearchHandlerZendLuceneTest::suite() );
        $this->addTest( ezcSearchSessionTest::suite() );
    }

    public static function suite()
    {
        return new ezcSearchSuite();
    }
}

?>
