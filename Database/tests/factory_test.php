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
 * @package Database
 * @subpackage Tests
 */

/**
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseFactoryTest extends ezcTestCase
{
    public function testWithoutImplementationType()
    {
        try
        {
            $dbparams = array( 'host' => 'localhost', 'user' => 'root', 'database' => 'ezc' );
            $db = ezcDbFactory::create( $dbparams );

            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
        }
    }

    public function testWithWrongImplementationType()
    {
        try
        {
            $dbparams = array( 'type' => 'unknown', 'host' => 'localhost', 'user' => 'root', 'database' => 'ezc' );
            $db = ezcDbFactory::create( $dbparams );

            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
        }
    }

    // test for bug #14464
    public function testWithWrongArgument()
    {
        try
        {
            $foo = ezcDbFactory::create( true );
            self::fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '1' that you were trying to assign to parameter 'dbParams' is invalid. Allowed values are: string or array.", $e->getMessage() );
        }
    }

    public function testGetImplementations()
    {
        $array = ezcDbFactory::getImplementations();
        $this->assertEquals( array( 'mysql', 'pgsql', 'oracle', 'sqlite', 'mssql' ), $array );
    }

    public function testGetImplementationsAfterAddingOne()
    {
        ezcDbFactory::addImplementation( 'test', 'ezcDbHandlerTest' );
        $array = ezcDbFactory::getImplementations();
        $this->assertEquals( array( 'mysql', 'pgsql', 'oracle', 'sqlite', 'mssql', 'test' ), $array );
    }

    public function testSqliteDSN1()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
        $db = ezcDbFactory::create( 'sqlite://:memory:' );
        $db = ezcDbFactory::create( 'sqlite:///tmp/testSqliteDSN1.sqlite' );
        $this->assertEquals( true, file_exists( '/tmp/testSqliteDSN1.sqlite' ) );
        unlink( '/tmp/testSqliteDSN1.sqlite' );
        $this->assertEquals( false, file_exists( ':memory:' ) );
    }

    public function testSqliteDSN2()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
        try
        {
            $db = ezcDbFactory::create( 'sqlite:///:memory:' );
            $this->fail( "Expected exception not thrown." );
        }
        catch ( PDOException $e )
        {
            $this->assertEquals( "SQLSTATE[HY000] [14] unable to open database file", $e->getMessage() );
        }
    }

    public function testSqliteDSN3()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
        try
        {
            $db = ezcDbFactory::create( 'sqlite://' );
            $this->fail( "Expected exception not thrown." );
        }
        catch ( ezcDbMissingParameterException $e )
        {
            $this->assertEquals( "The option 'database' is required in the parameter 'dbParams'.", $e->getMessage() );
        }
    }

    public function testSqliteDSN4()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') || ezcBaseFeatures::os() !== 'Windows' )
        {
            $this->markTestSkipped( 'Windows only test' );
            return;
        }
        $db = ezcDbFactory::create( 'sqlite:///c:\tmp\foo.sqlite' );
        $this->assertEquals( true, file_exists( 'c:\tmp\foo.sqlite' ) );
        unlink( 'c:\tmp\foo.sqlite' );
    }

    public function testParamsSqliteDatabase1()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
        try
        {
            $db = ezcDbFactory::create( array( 'handler' => 'sqlite' ) );
            $this->fail( "Expected exception not thrown." );
        }
        catch ( ezcDbMissingParameterException $e )
        {
            $this->assertEquals( "The option 'database' is required in the parameter 'dbParams'.", $e->getMessage() );
        }
    }

    public function testParamsSqliteDatabase2()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
        $db = ezcDbFactory::create( array( 'handler' => 'sqlite', 'port' => 'memory' ) );
        $this->assertEquals( false, file_exists( 'memory' ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseFactoryTest" );
    }
}
?>
