<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/testclasses.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsJsonViewTest extends ezcTestCase
{
    function setUp()
    {
        $this->baseDir = dirname( __FILE__ ) . '/../testfiles/views/json/';
    }

    function testSimpleView()
    {
        $view = new ezcMvcJsonViewHandler( 'test1' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( true );

        self::assertEquals( file_get_contents( $this->baseDir . 'simple.json' ), $view->getResult() );
    }

    function testNonLastSimpleView()
    {
        $view = new ezcMvcJsonViewHandler( 'test1' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( false );

        self::assertEquals( array( 'name' => 'Churchill', 'quote' => '“Genius is independent of situation.”' ), $view->getResult() );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'name' => 'Churchill', 'quote' => '“If you are going through hell, keep going.”' );

        $view    = new testOneJsonView( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'oneview.json' ), $response->body );
    }

    public function testTwoViews()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array(
            'name' => 'Churchill',
            'quote' => '“If you are going through hell, keep going.”',
            'navMaxPages' => 5,
            'navCurrentPage' => 2
        );

        $view    = new testTwoJsonViews( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'twoviews.json' ), $response->body );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
