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

    public function testRenderSimpleTables()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/simple_tables.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }

    public function testRenderTableWithList()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/tables_with_list.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }

    public function testRenderStackedTable()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/stacked_table.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }

    public function testRenderPageWrappedTable()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/wrapped_table.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }
}

?>
