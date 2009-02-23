<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcTemplateLocaleTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->basePath = $this->createTempDir( "ezcTemplate_" );
        $this->templatePath = $this->basePath . "/templates";
        $this->compilePath = $this->basePath . "/compiled";

        mkdir ( $this->templatePath );
        mkdir ( $this->compilePath );

        $config = ezcTemplateConfiguration::getInstance();
        $config->templatePath = $this->templatePath;
        $config->compilePath = $this->compilePath;
        $config->context = new ezcTemplateNoContext;
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testLocale()
    {
        $this->setLocale( LC_ALL, 'de_DE', 'de_DE.UTF-8', 'deu', 'german' );

        $a = 3.4;
        $this->assertEquals("3,4", (string)$a);
    }


    public function testFloats()
    {
        $this->setLocale( LC_ALL, 'de_DE', 'de_DE.UTF-8', 'deu', 'german' );

        $template = new ezcTemplate();
        $file =  "float.ezt";
        
        // The number 3.14 should not be translated to 3,14. The array size should be one, not two.
        file_put_contents( $this->templatePath . "/". $file, "{array_count(array(3.14))}" );
        $this->assertEquals(1, $template->process( $file ), "Number 3.14 is internally translated to 3,14 when the de_DE locale is used.");
    }
}
?>
