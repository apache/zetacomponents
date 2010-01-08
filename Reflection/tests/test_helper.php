<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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