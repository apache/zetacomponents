<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require 'routes/regexp.php';
require 'routes/rails.php';
require 'router.php';
require 'views/php.php';
require 'views/json.php';
require 'view.php';
require 'request_parsers/http.php';
require 'response_writers/http.php';
require 'response_filters/gzip.php';
require 'response_filters/gzdeflate.php';
require 'response_filters/recode.php';
require 'dispatchers/configurable.php';
require 'structs/routing_information.php';

/**
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'MvcTools' );

        $this->addTest( ezcMvcToolsRegexpRouteTest::suite() );
        $this->addTest( ezcMvcToolsRailsRouteTest::suite() );
        $this->addTest( ezcMvcToolsRouterTest::suite() );
        $this->addTest( ezcMvcToolsViewTest::suite() );
        $this->addTest( ezcMvcToolsPhpViewTest::suite() );
        $this->addTest( ezcMvcToolsJsonViewTest::suite() );
        $this->addTest( ezcMvcToolsHttpRequestParserTest::suite() );
        $this->addTest( ezcMvcToolsHttpResponseWriterTest::suite() );
        $this->addTest( ezcMvcToolsGzipResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsGzDeflateResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsRecodeResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsConfigurableDispatcherTest::suite() );
        $this->addTest( ezcMvcRoutingInformationTest::suite() );
    }

    public static function suite()
    {
        return new ezcMvcToolsSuite();
    }
}

?>
