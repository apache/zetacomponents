<?php
/**
 * ezcDocumentPdfDriverTcpdfTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'base.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfTableRendererTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;
    protected $styles;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTableDocuments()
    {
        return array(
            array( dirname( __FILE__ ) . '/../files/pdf/simple_tables.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/tables_with_list.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/stacked_table.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/wrapped_table.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/irregular_tables_1.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/irregular_tables_2.xml' ),
            array( dirname( __FILE__ ) . '/../files/pdf/irregular_tables_3.xml' ),
        );
    }

    /**
     * @dataProvider getTableDocuments
     */
    public function testRenderTables( $file )
    {
        $this->renderFullDocument( $file, __CLASS__ . '_' . basename( $file, '.xml' ) . '.svg', array() );
    }
}

?>
