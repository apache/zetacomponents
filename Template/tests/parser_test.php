<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once "invariant_parse_cursor.php";

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateParserTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        // // required because of Reflection autoload bug
        class_exists( 'ezcTemplateSourceCode' );
        $this->manager = new ezcTemplate();
        // ezcMock::generate( 'ezcTemplateParser', array( "reportElementCursor" ), 'MockElement_ezcTemplateParser' );

        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

    protected function tearDown()
    {
    }


    public function testBlarp()
    {
        /*
        $text = file_get_contents( $this->templatePath . "simple_test.tpl" );

        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new ezcTemplateParser( $source, $this->manager );

        $program = $parser->parseIntoNodeTree();

        echo ezcTemplateTstTreeOutput::output( $program );

        $tstToAst = new ezcTemplateTstToAstTransformer();
        $program->accept( $tstToAst );

        $g = new ezcTemplateAstToPhpGenerator( "/dev/stdout" );
        $tstToAst->programNode->accept($g);





 
        // $cb = new ezcTemplateAstBuilder();

        $echo = new ezcTemplateEchoAstNode( array( new ezcTemplateLiteralAstNode( "Hello\n world" ) ) );
        $body = new ezcTemplateBodyAstNode();
        $body->appendStatement( $echo );

        echo ezcTemplateAstTreeOutput::output( $body );
        */

       

        // echo $program->getFirstChild()->text;

    }

}

?>
