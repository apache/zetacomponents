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
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'Authentication/tests/test.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationGroupMultipleTest extends ezcAuthenticationTest
{
    protected static $data1;
    protected static $data2;
    protected static $results;

    public static function suite()
    {
        self::$data1 = array( // id_credentials, encrypted_token, token_method
            array( 'qwerty', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'sha1' ),
            array( 'wrong value', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'sha1' ),
            );

        self::$data2 = array( // id_credentials, encrypted_token, token_method
            array( 'asdfgh', 'a152e841783914146e4bcd4f39100686', 'md5' ),
            array( 'wrong value', 'a152e841783914146e4bcd4f39100686', 'md5' ),
            );

        self::$results = array( // the first 2 values are keys in $data1 and $data2
                                // the 3rd value is the mode for the Group filter
                                // the 4th value is the expected result for assertEquals()
            array( 0, 0, ezcAuthenticationGroupFilter::MODE_AND, true ),
            array( 0, 1, ezcAuthenticationGroupFilter::MODE_AND, false ),

            array( 0, 0, ezcAuthenticationGroupFilter::MODE_OR, true ),
            array( 0, 1, ezcAuthenticationGroupFilter::MODE_OR, true ),

            array( 1, 0, ezcAuthenticationGroupFilter::MODE_AND, false ),
            array( 1, 1, ezcAuthenticationGroupFilter::MODE_AND, false ),

            array( 1, 0, ezcAuthenticationGroupFilter::MODE_OR, true ),
            array( 1, 1, ezcAuthenticationGroupFilter::MODE_OR, false ),
            );

        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testGroupMultipleCredentialsAddFilter()
    {
        foreach ( self::$results as $result )
        {
            $credentials1 = new ezcAuthenticationIdCredentials( self::$data1[$result[0]][0] );
            $credentials2 = new ezcAuthenticationIdCredentials( self::$data2[$result[1]][0] );

            $authentication = new ezcAuthentication( $credentials1 );

            $filter1 = new ezcAuthenticationTokenFilter( self::$data1[$result[0]][1], self::$data1[$result[0]][2] );
            $filter2 = new ezcAuthenticationTokenFilter( self::$data2[$result[1]][1], self::$data2[$result[1]][2] );

            $options = new ezcAuthenticationGroupOptions();
            $options->multipleCredentials = true;
            $options->mode = $result[2];

            $group = new ezcAuthenticationGroupFilter( array(), $options );
            $group->addFilter( $filter1, $credentials1 );
            $group->addFilter( $filter2, $credentials2 );

            $authentication->addFilter( $group );

            $this->assertEquals( $result[3], $authentication->run(), "Test failed for ({$result[0]}, {$result[1]}, {$result[2]})." );
        }
    }

    public function testGroupMultipleCredentialsConstructor()
    {
        foreach ( self::$results as $result )
        {
            $credentials1 = new ezcAuthenticationIdCredentials( self::$data1[$result[0]][0] );
            $credentials2 = new ezcAuthenticationIdCredentials( self::$data2[$result[1]][0] );

            $authentication = new ezcAuthentication( $credentials1 );

            $filter1 = new ezcAuthenticationTokenFilter( self::$data1[$result[0]][1], self::$data1[$result[0]][2] );
            $filter2 = new ezcAuthenticationTokenFilter( self::$data2[$result[1]][1], self::$data2[$result[1]][2] );

            $options = new ezcAuthenticationGroupOptions();
            $options->multipleCredentials = true;
            $options->mode = $result[2];

            $group = new ezcAuthenticationGroupFilter( array( array( $filter1, $credentials1 ), array( $filter2, $credentials2 ) ), $options );

            $authentication->addFilter( $group );

            $this->assertEquals( $result[3], $authentication->run(), "Test failed for ({$result[0]}, {$result[1]}, {$result[2]})." );
        }
    }

    public function testGroupMultipleCredentialsFailAddFilterMissingCredentials()
    {
        $filter1 = new ezcAuthenticationTokenFilter( self::$data1[0][1], self::$data1[0][2] );
        $filter2 = new ezcAuthenticationTokenFilter( self::$data2[1][1], self::$data2[1][2] );

        $options = new ezcAuthenticationGroupOptions();
        $options->multipleCredentials = true;

        $group = new ezcAuthenticationGroupFilter( array(), $options );

        try
        {
            $group->addFilter( $filter1 );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationException $e )
        {
            $this->assertSame( 'A credentials object must be specified for each filter when the multipleCredentials option is enabled.', $e->getMessage() );
        }
    }

    public function testGroupMultipleCredentialsFailConstructorMissingCredentials()
    {
        $filter1 = new ezcAuthenticationTokenFilter( self::$data1[0][1], self::$data1[0][2] );
        $filter2 = new ezcAuthenticationTokenFilter( self::$data2[1][1], self::$data2[1][2] );

        $options = new ezcAuthenticationGroupOptions();
        $options->multipleCredentials = true;

        try
        {
            $group = new ezcAuthenticationGroupFilter( array( $filter1, $filter2 ), $options );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationException $e )
        {
            $this->assertEquals( 'A credentials object must be specified for each filter when the multipleCredentials option is enabled.', $e->getMessage() );
        }
    }
}
?>
