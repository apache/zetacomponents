<?php
/**
 * @package Workflow
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'class_test.php';
require_once 'class_external_test.php';
require_once 'class_instance_test.php';
require_once 'object_test.php';
require_once 'reflection_test.php';
require_once 'extension_test.php';
require_once 'extension_external_test.php';
require_once 'function_test.php';
require_once 'function_external_test.php';
require_once 'method_test.php';
require_once 'method_external_test.php';
require_once 'method_from_class_test.php';
require_once 'methods_from_class_test.php';
require_once 'parameter_test.php';
require_once 'parameter_by_name_test.php';
require_once 'parameters_from_function_test.php';
require_once 'parameter_external_test.php';
require_once 'parser_test.php';
require_once 'property_test.php';
require_once 'property_from_class_test.php';
require_once 'properties_from_class_test.php';
require_once 'annotation_factory_test.php';
require_once 'type_factory_test.php';
require_once 'type_mapper_test.php';
require_once 'abstract_type_test.php';
require_once 'primitive_type_test.php';
require_once 'array_type_test.php';
require_once 'object_type_test.php';
require_once 'mixed_type_test.php';
if ( file_exists( dirname( __FILE__ ) . '/staticReflection/source/pdepend/reflection/Autoloader.php' ) )
{
    require_once 'staticReflection/source/pdepend/reflection/Autoloader.php';
    spl_autoload_register('__autoload');
    spl_autoload_register(array(new pdepend\reflection\Autoloader, 'autoload'));

    require_once 'class_static_test.php';
    require_once 'method_static_test.php';
    require_once 'parameter_static_test.php';
}

require_once 'test_classes/functions.php';
require_once 'test_classes/methods.php';
require_once 'test_classes/methods2.php';
require_once 'test_classes/MyReflectionClass.php';
require_once 'test_classes/MyReflectionProperty.php';
require_once 'test_classes/MyReflectionMethod.php';
require_once 'test_classes/MyReflectionFunction.php';
require_once 'test_classes/MyReflectionExtension.php';
require_once 'test_classes/webservice.php';
require_once 'test_classes/interface.php';
require_once 'test_classes/BaseClass.php';
require_once 'test_classes/SomeClass.php';

require_once 'test_helper.php';

/**
 * @package Reflection
 * @subpackage Tests
 */
class ezcReflectionSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('Reflection');

        $this->addTest( ezcReflectionAnnotationFactoryTest::suite() );
        $this->addTest( ezcReflectionDocCommentParserTest::suite() );

        $this->addTest( ezcReflectionTypeMapperTest::suite() );
        $this->addTest( ezcReflectionAbstractTypeTest::suite() );
        $this->addTest( ezcReflectionPrimitiveTypeTest::suite() );
        $this->addTest( ezcReflectionArrayTypeTest::suite() );
        $this->addTest( ezcReflectionObjectTypeTest::suite() );
        $this->addTest( ezcReflectionMixedTypeTest::suite() );
        $this->addTest( ezcReflectionTypeFactoryTest::suite() );

        $this->addTest( ezcReflectionClassTest::suite() );
        $this->addTest( ezcReflectionClassExternalTest::suite() );
        $this->addTest( ezcReflectionClassInstanceTest::suite() );
        $this->addTest( ezcReflectionObjectTest::suite() );

        $this->addTest( ezcReflectionFunctionTest::suite() );
        $this->addTest( ezcReflectionFunctionExternalTest::suite() );
        $this->addTest( ezcReflectionMethodTest::suite() );
        $this->addTest( ezcReflectionMethodExternalTest::suite() );
        $this->addTest( ezcReflectionMethodFromClassTest::suite() );
        $this->addTest( ezcReflectionMethodsFromClassTest::suite() );

        $this->addTest( ezcReflectionParameterTest::suite() );
        $this->addTest( ezcReflectionParameterByNameTest::suite() );
        $this->addTest( ezcReflectionParametersFromFunctionTest::suite() );
        $this->addTest( ezcReflectionParameterExternalTest::suite() );

        $this->addTest( ezcReflectionPropertyTest::suite() );
        $this->addTest( ezcReflectionPropertyFromClassTest::suite() );
        $this->addTest( ezcReflectionPropertiesFromClassTest::suite() );

        if ( file_exists( dirname( __FILE__ ) . '/staticReflection/source/pdepend/reflection/Autoloader.php' ) )
        {
            $this->addTest( ezcReflectionClassStaticTest::suite() );
            $this->addTest( ezcReflectionMethodStaticTest::suite() );
            $this->addTest( ezcReflectionParameterStaticTest::suite() );
        }

        $this->addTest( ezcReflectionExtensionTest::suite() );
        $this->addTest( ezcReflectionExtensionExternalTest::suite() );

        $this->addTest( ezcReflectionTest::suite() );
    }

    public static function suite()
    {
        return new ezcReflectionSuite;
    }
}
?>
