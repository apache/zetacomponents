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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'test_case.php';

/**
 * Misc tests for ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionMiscTest extends ezcPersistentSessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    // Properties 

    public function testDatabaseProperty()
    {
        $db = ezcDbInstance::get();
        $session = new ezcPersistentSession( $db,
                                             new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" ) );
        $this->assertSame( $db, $session->database );
        try
        {
            $session->database = $db;
            $this->fail( "Did not get exception when expected" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
        }
    }

    public function testDefinitionManagerProperty()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session = new ezcPersistentSession( $db, $manager );
        $this->assertSame( $manager, $session->definitionManager );
        try
        {
            $session->definitionManager = $manager;
            $this->fail( "Did not get exception when expected" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
        }
    }

    // Overloading

    public function testGetAccessFailure()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session = new ezcPersistentSession( $db, $manager );

        try
        {
            $foo = $session->non_existent;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on get access to non existent property." );
    }
    
    public function testSetAccessFailure()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session = new ezcPersistentSession( $db, $manager );

        try
        {
            $session->database = null;
            $this->fail( "Exception not thrown on set access to ezcPersistentSession->database." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }

        try
        {
            $session->definitionManager = null;
            $this->fail( "Exception not thrown on set access to ezcPersistentSession->definitionManager." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }

        try
        {
            $session->non_existent = null;
            $this->fail( "Exception not thrown on set access to non existent property." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }
    }
    
    public function testExportImportDefinitions()
    {
        $classes = array(
            'PersistentTestObject',
            'RelationTestAddress',
            'RelationTestEmployer',
            'RelationTestBirthday',
            'RelationTestPerson',
        );
        $dir = $this->createTempDir( 'export' );

        foreach( $classes as $class )
        {
            $def = $this->session->definitionManager->fetchDefinition( $class );

            $file = $dir . "/$class.php";
            

            file_put_contents( $file, "<?php\nreturn " . var_export( $def, true ) . ";\n?>" );
            $deserialized = require $file;

            $this->assertEquals(
                $def,
                $deserialized,
                "Objects of class $class not exported/imported correctly."
            );

        }

        $this->removeTempDir();
    }

    public function testInvalidStateException()
    {
        $obj = new PersistentTestObjectInvalidState();
        
        $obj->state = null;
        try
        {
            $this->session->save( $obj );
            $this->fail( 'Exception not thrown with state null.' );
        }
        catch( ezcPersistentInvalidObjectStateException $e ) {}
        
        $obj->state = 23;
        try
        {
            $this->session->save( $obj );
            $this->fail( 'Exception not thrown with state integer.' );
        }
        catch( ezcPersistentInvalidObjectStateException $e ) {}
        
        $obj->state = new stdClass();
        try
        {
            $this->session->save( $obj );
            $this->fail( 'Exception not thrown with state object.' );
        }
        catch( ezcPersistentInvalidObjectStateException $e ) {}
        
        $obj->state = 'foo';
        try
        {
            $this->session->save( $obj );
            $this->fail( 'Exception not thrown with state string.' );
        }
        catch( ezcPersistentInvalidObjectStateException $e ) {}
        
        $obj->state = true;
        try
        {
            $this->session->save( $obj );
            $this->fail( 'Exception not thrown with state bool.' );
        }
        catch( ezcPersistentInvalidObjectStateException $e ) {}
    }

    public function testObjectDefinitionSerialization()
    {
        $persistentClasses = array(
            'PersistentTestObject',
            'PersistentTestObjectConverter',
            'RelationTestAddress',
            'RelationTestBirthday',
            'RelationTestEmployer',
            'RelationTestPerson',
            'RelationTestSecondPerson',
        );

        foreach( $persistentClasses as $persistentClass )
        {
            $original = $this->session->definitionManager->fetchDefinition( 'RelationTestPerson' );
            $export   = 'return ' . var_export( $original, true ) . ';';
            $import   = eval( $export );

            $this->assertEquals(
                $original,
                $import,
                "Persistent object definition not correctly deserialized for class $persistentClass."
            );

        }
    }
}

?>
