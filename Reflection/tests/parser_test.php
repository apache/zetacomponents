<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionDocCommentParserTest extends ezcTestCase
{
    /**
     * @var string[]
     */
    private static $docs;

    public function testGetAnnotationsByName() {
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[0]);
        $annotations = $parser->getAnnotationsByName('copyright');
        self::assertEquals(1, count($annotations));

        $annotations = $parser->getAnnotationsByName('filesource');
        self::assertEquals(1, count($annotations));

        $annotations = $parser->getAnnotationsByName('noneExistingAnnotation');
        self::assertEquals(0, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[2]);
        $annotations = $parser->getAnnotationsByName('oneannotationonly');
        self::assertEquals(1, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[3]);
        $annotations = $parser->getAnnotationsByName('param');
        self::assertEquals(1, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[4]);
        $annotations = $parser->getAnnotationsByName('foobar');
        self::assertEquals(1, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[6]);
        $annotations = $parser->getAnnotationsByName('author');
        self::assertEquals(1, count($annotations));
    }

    public function testGetAnnotations() {
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[0]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(6, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[1]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(0, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[2]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(1, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[3]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(2, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[4]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(3, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[5]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(0, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[6]);
        $annotations = $parser->getAnnotations();
        self::assertEquals(9, count($annotations));
    }

    public function testGetParamAnnotations() {
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[0]);
        $annotations = $parser->getParamAnnotations();
        self::assertEquals(0, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[3]);
        $annotations = $parser->getParamAnnotations();
        self::assertEquals(1, count($annotations));

        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[6]);
        $annotations = $parser->getParamAnnotations();
        self::assertEquals(3, count($annotations));
        self::assertEquals('test', $annotations[0]->getParamName());
        self::assertEquals('string', $annotations[0]->getTypeName());

        self::assertEquals('test3', $annotations[2]->getParamName());
        self::assertEquals('NonExistingType', $annotations[2]->getTypeName());
        
        
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $m2 = new ezcReflectionFunction( 'm2' );
        $parser->parse( $m2->getDocComment() );
        $annotations = $parser->getParamAnnotations();
        self::assertEquals(2, count($annotations));
        self::assertEquals('DocuFlaw', $annotations[0]->getParamName());
        self::assertEquals('NULL', $annotations[0]->getTypeName());
        self::assertEquals( array( 'NULL', 'DocuFlaw' ), $annotations[0]->getParams() );
        // testAddDescriptionLine
        $originalDescription = $annotations[0]->getDescription();
        $additionalDescriptionLine
            = 'This is an additional line of description.';
        $annotations[0]->addDescriptionLine( $additionalDescriptionLine );
        self::assertEquals(
            $originalDescription . "\n" . $additionalDescriptionLine,
            $annotations[0]->getDescription()
        );
        

        self::assertNull($annotations[1]->getParamName());
        self::assertEquals('boolean', $annotations[1]->getTypeName());
        self::assertEquals( array( 'boolean' ), $annotations[1]->getParams() );
        
    }

    public function testGetVarAnnotations() {
        $comment = <<<EOF
/**
* @var string
*/
EOF;
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse($comment);
		$annotations = $parser->getVarAnnotations();
		self::assertEquals(1, count($annotations));
		self::assertType('ezcReflectionAnnotationVar', $annotations[0]);
		self::assertEquals('string', $annotations[0]->getTypeName());
		self::assertEquals('', $annotations[0]->getDescription());
        
        $comment = <<<EOF
   /**
    * @var bool[] An array of
    *      boolean values.
    */
EOF;
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse($comment);
		$annotations = $parser->getVarAnnotations();
		self::assertEquals(1, count($annotations));
		self::assertType('ezcReflectionAnnotationVar', $annotations[0]);
        self::assertEquals("An array of\nboolean values.", $annotations[0]->getDescription());
        self::assertEquals('bool[]', $annotations[0]->getTypeName());
        $type = ezcReflectionApi::getReflectionTypeFactory()->getType($annotations[0]->getTypeName());
		self::assertType('ezcReflectionArrayType', $type);
        self::assertTrue($type->isArray());
        $arrayType = $type->getArrayType();
		self::assertType('ezcReflectionPrimitiveType', $arrayType);
        self::assertTrue($arrayType->isPrimitive());
        self::assertTrue($arrayType->isScalarType());
        self::assertEquals('boolean', $arrayType->getTypeName());
    }

    public function testGetReturnAnnotations() {
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[6]);
        $annotations = $parser->getReturnAnnotations();

        self::assertEquals("Hello\nWorld!", $annotations[0]->getDescription());
        self::assertEquals('string', $annotations[0]->getTypeName());
    }

    public function testHasAnnotation() {
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse(self::$docs[6]);
        self::assertTrue($parser->hasAnnotation('return'));
    }

    public function testGetShortDescription() {
        $class = new ReflectionClass('TestWebservice');
        $doc = $class->getDocComment();
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse($doc);
        $desc = $parser->getShortDescription();

        self::assertEquals('This is the short description', $desc);
    }

    public function testGetLongDescription() {
        $class = new ReflectionClass('TestWebservice');
        $doc = $class->getDocComment();
        $parser = ezcReflectionApi::getDocCommentParserInstance();
        $parser->parse($doc);
        $desc = $parser->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valid, too.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public static function suite()
    {
        self::$docs = array();
        $class = new ReflectionClass('ezcReflectionDocCommentParserTest');
        self::$docs[] = $class->getDocComment();

        $class = new ReflectionClass('TestMethods');
        self::$docs[] = $class->getDocComment();
        $methods = $class->getMethods();

        foreach ($methods as $method) {
            self::$docs[] = $method->getDocComment();
        }

        return new PHPUnit_Framework_TestSuite( "ezcReflectionDocCommentParserTest" );
    }
}
?>
