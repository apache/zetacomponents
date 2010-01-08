<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionAnnotationFactoryTest extends ezcTestCase
{
    public function testCreateAnnotation() {
        $param  = ezcReflectionAnnotationFactory::createAnnotation('param', array('param', 'string', 'param'));

        self::assertType('ezcReflectionAnnotationParam', $param);

        $var    = ezcReflectionAnnotationFactory::createAnnotation('var', array('var', 'string'));
        self::assertType('ezcReflectionAnnotationVar', $var);

        $return = ezcReflectionAnnotationFactory::createAnnotation('return', array('return', 'string', 'hello', 'world'));
        self::assertType('ezcReflectionAnnotationReturn', $return);
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionAnnotationFactoryTest" );
    }
}
?>
