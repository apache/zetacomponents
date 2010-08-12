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
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . '/../data/persistent_test_object.php';
require_once dirname( __FILE__ ) . '/../data/persistent_test_object_no_id.php';
require_once dirname( __FILE__ ) . '/../data/persistent_test_object_converter.php';
require_once dirname( __FILE__ ) . '/../data/persistent_test_object_invalid_state.php';

require_once dirname( __FILE__ ) . '/../data/relation_test_address.php';
require_once dirname( __FILE__ ) . '/../data/relation_test_person.php';
require_once dirname( __FILE__ ) . '/../data/relation_test_birthday.php';
require_once dirname( __FILE__ ) . '/../data/relation_test_employer.php';

require_once dirname( __FILE__ ) . '/../data/multi_relation_test_person.php';

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionTest extends ezcTestCase
{
    protected $session = null;
    protected $hasTables = false;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }

        PersistentTestObject::setupTable();
        PersistentTestObject::insertCleanData();
        // Uncomment to store schema.
        // PersistentTestObject::saveSqlSchemas();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/../data/" )
        );
    }

    protected function tearDown()
    {
        PersistentTestObject::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentSessionTest' );
    }
}

?>
