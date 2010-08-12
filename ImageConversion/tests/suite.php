<?php
/**
 * ezcImageConversionSuite
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
 * @package ImageConversion
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'converter_test.php';
require_once 'transformation_test.php';
require_once 'handlergd_test.php';
require_once 'filtersgd_test.php';
require_once 'handlershell_test.php';
require_once 'filtersshell_test.php';
require_once 'save_options_test.php';

class ezcImageConversionSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "ImageConversion" );

        $this->addTest( ezcImageConversionConverterTest::suite() );
        $this->addTest( ezcImageConversionTransformationTest::suite() );

        $this->addTest( ezcImageConversionHandlerGdTest::suite() );
        $this->addTest( ezcImageConversionFiltersGdTest::suite() );

        $this->addTest( ezcImageConversionHandlerShellTest::suite() );
        $this->addTest( ezcImageConversionFiltersShellTest::suite() );

        $this->addTest( ezcImageConversionSaveOptionsTest::suite() );
    }

    public static function suite()
    {
        return new ezcImageConversionSuite( "ezcImageConversionSuite" );
    }
}
?>
