<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
require 'routes/catchall.php';
require 'router.php';
require 'controller.php';
require 'views/php.php';
require 'views/json.php';
require 'view.php';
require 'request_parsers/http.php';
require 'response_writers/http.php';
require 'response_filters/gzip.php';
require 'response_filters/gzdeflate.php';
require 'response_filters/recode.php';
require 'dispatchers/configurable.php';
require 'structs/external_redirect.php';
require 'structs/filter_definition.php';
require 'structs/internal_redirect.php';
require 'structs/request_accept.php';
require 'structs/request_authentication.php';
require 'structs/request_file.php';
require 'structs/request.php';
require 'structs/request_raw_http.php';
require 'structs/request_user_agent.php';
require 'structs/response.php';
require 'structs/result_cache.php';
require 'structs/result_content.php';
require 'structs/result_cookie.php';
require 'structs/result.php';
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
        $this->addTest( ezcMvcToolsCatchAllRouteTest::suite() );
        $this->addTest( ezcMvcToolsRouterTest::suite() );
        $this->addTest( ezcMvcToolsControllerTest::suite() );
        $this->addTest( ezcMvcToolsViewTest::suite() );
        $this->addTest( ezcMvcToolsPhpViewTest::suite() );
        $this->addTest( ezcMvcToolsJsonViewTest::suite() );
        $this->addTest( ezcMvcToolsHttpRequestParserTest::suite() );
        $this->addTest( ezcMvcToolsHttpResponseWriterTest::suite() );
        $this->addTest( ezcMvcToolsGzipResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsGzDeflateResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsRecodeResponseFilterTest::suite() );
        $this->addTest( ezcMvcToolsConfigurableDispatcherTest::suite() );
        $this->addTest( ezcMvcFilterDefinitionTest::suite() );
        $this->addTest( ezcMvcInternalRedirectTest::suite() );
        $this->addTest( ezcMvcRequestAcceptTest::suite() );
        $this->addTest( ezcMvcRequestAuthenticationTest::suite() );
        $this->addTest( ezcMvcRequestFileTest::suite() );
        $this->addTest( ezcMvcRequestTest::suite() );
        $this->addTest( ezcMvcHttpRawRequestTest::suite() );
        $this->addTest( ezcMvcRequestUserAgentTest::suite() );
        $this->addTest( ezcMvcResponseTest::suite() );
        $this->addTest( ezcMvcResultCacheTest::suite() );
        $this->addTest( ezcMvcResultContentTest::suite() );
        $this->addTest( ezcMvcResultCookieTest::suite() );
        $this->addTest( ezcMvcResultTest::suite() );
        $this->addTest( ezcMvcRoutingInformationTest::suite() );
        $this->addTest( ezcMvcExternalRedirectTest::suite() );
    }

    public static function suite()
    {
        return new ezcMvcToolsSuite();
    }
}

?>
