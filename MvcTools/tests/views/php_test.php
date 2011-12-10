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
class ezcMvcToolsPhpViewTest extends ezcTestCase
{
    function setUp()
    {
        $this->baseDir = dirname( __FILE__ ) . '/../testfiles/views/php/';
    }

    function testSimpleView()
    {
        $view = new ezcMvcPhpViewHandler( 'test1', $this->baseDir . 'simple.php' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( false );

        self::assertEquals( file_get_contents( $this->baseDir . 'simple.php.txt' ), $view->getResult() );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'name' => 'Churchill', 'quote' => '“If you are going through hell, keep going.”' );

        $view    = new testOnePhpView( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'oneview.php.txt' ), $response->body );
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

        $view    = new testTwoPhpViews( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'twoviews.php.txt' ), $response->body );
    }

    public function testNonExistingFile()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array(
            'name' => 'Churchill',
            'quote' => '“If you are going through hell, keep going.”',
            'navMaxPages' => 5,
            'navCurrentPage' => 2
        );

        $view    = new testNonExistingPhpView( $request, $result );
        $dir = dirname( __FILE__ );
        $dir = realpath( "$dir/.." );

        try
        {
            $response = $view->createResponse();
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertEquals( "The php template file '{$dir}/testfiles/views/php/not_here.php' could not be found.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsPhpViewTest" );
    }
}
?>
