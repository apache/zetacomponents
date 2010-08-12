<?php
/**
 * ezcPersistentObjectDatabaseSchemaTieinSuite
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
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once dirname( __FILE__ ) . "/generator_test.php";

require_once dirname( __FILE__ ) . "/template_functions_test.php";
require_once dirname( __FILE__ ) . "/template_writer_options_test.php";
require_once dirname( __FILE__ ) . "/template_writer_test.php";

/**
 * Test suite for PersistentObjectDatabaseSchemaTiein package.
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcPersistentObjectDatabaseSchemaTieinSuite extends PHPUnit_Framework_TestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName( "PersistentObjectDatabaseSchemaTiein" );
		$this->addTest( ezcPersistentObjectSchemaGeneratorTest::suite() );
		$this->addTest( ezcPersistentObjectSchemaTemplateFunctionsTest::suite() );
		$this->addTest( ezcPersistentObjectTemplateSchemaWriterOptionsTest::suite() );
		$this->addTest( ezcPersistentObjectTemplateSchemaWriterTest::suite() );
	}

    public static function suite()
    {
        return new ezcPersistentObjectDatabaseSchemaTieinSuite( "ezcPersistentObjectDatabaseSchemaTieinSuite" );
    }
}
?>
