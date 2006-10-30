<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */

class ezcTemplateCacheTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
       /* 
        $this->basePath = $this->createTempDir( "ezcTemplate_" );
        //$this->templatePath = $this->basePath . "/templates";
        $this->templatePath = "Template/tests/templates";
        $this->compilePath = $this->basePath . "/compiled";

        echo ( $this->templatePath );

        //mkdir ( $this->templatePath );
        mkdir ( $this->compilePath );

        $config = ezcTemplateConfiguration::getInstance();
        $config->templatePath = $this->templatePath;
        $config->compilePath = $this->compilePath;
        */
    }

    protected function tearDown()
    {
    }

    public function testDynamicBlock()
    {
/*        $t = new ezcTemplate();
        $t->process ("cache_dynamic.tpl");


        var_dump( $t->output );
 */
    }
}

?>
