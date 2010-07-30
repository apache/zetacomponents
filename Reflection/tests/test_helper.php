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
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ReflectionTestHelper {

    /**
     * Helper method to delete a given value from an array
     *
     * @param mixed $needle
     * @param mixed $array
     */
    static public function deleteFromArray($needle, &$array) {
        foreach ($array as $key => $value) {
            if ($value == $needle) {
                unset($array[$key]);
                return;
            }
        }
    }

    /**
     * Checks if all expected annotations and only these are set
     *
     * @param string[] $expectedAnnotations
     * @param ezcReflectionAnnotation[] $annotations
     * @param ezcTestCase $test
     */
    static public function expectedAnnotations($expectedAnnotations, $annotations, $test) {
        foreach ($annotations as $annotation) {
            $test->assertType('ezcReflectionAnnotation', $annotation);
            $test->assertContains($annotation->getName(), $expectedAnnotations);

            self::deleteFromArray($annotation->getName(), $expectedAnnotations);
        }
        $test->assertEquals(0, count($expectedAnnotations));
    }


    /**
     * Checks if all expected parameters and only these are set
     *
     * @param string[] $expectedAnnotations
     * @param ezcReflectionAnnotation[] $annotations
     * @param ezcTestCase $test
     */
    static public function expectedParams($expectedParams, $params, $test) {
        foreach ($params as $param) {
            $test->assertType('ezcReflectionParameter', $param);
            $test->assertContains($param->getName(), $expectedParams);

            self::deleteFromArray($param->getName(), $expectedParams);
        }
        $test->assertEquals(0, count($expectedParams));
    }

}

?>