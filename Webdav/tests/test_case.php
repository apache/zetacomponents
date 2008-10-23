<?php
/**
 * File containing the webdav base test case class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extended test case to backup and restore $_SERVER array, to make it possible
 * to fake values in there.
 * 
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavTestCase extends ezcTestCase
{
    /**
     * Backup server array before running a test and restor it afterwards.
     *
     * Property may be modified in setup method to omit this behaviour.
     * 
     * @var bool
     */
    protected $backupServerArray = true;

    /**
     * Runs the bare test sequence.
     *
     * @access public
     */
    public function runBare()
    {
        // Backup server array if requested
        if ( $this->backupServerArray )
        {
            $serverBackup = $_SERVER;
        }

        // Run original test method
        parent::runBare();

        // Restore server array
        if ( $this->backupServerArray )
        {
            $_SERVER = $serverBackup;
        }
    }

    protected function setUp()
    {
        ezcWebdavServer::getInstance()->reset();
    }

    protected function assertDomTreeEquals( DOMNode $expected, DOMNode $result, $level = 0 )
    {
        $this->assertDomNodeEquals( $expected, $result, $level );

        if ( $expected->hasChildNodes() )
        {
            for ( $i = 0; $i < $expected->childNodes->length; ++$i )
            {
                $this->assertDomTreeEquals(
                    $expected->childNodes->item( $i ),
                    $result->childNodes->item( $i ),
                    ++$level
                );
            }
        }
    }

    protected function assertDomNodeEquals( DOMNode $expected, DOMNode $result, $level )
    {
        $this->assertEquals(
            $expected->nodeType,
            $result->nodeType,
            "Node type missmatched {$expected->nodeType} expected, {$result->nodeType} received. " . $this->getNodeInfo( $expected, $result, $level )
        );
        $this->assertEquals(
            $expected->nodeType,
            $result->nodeType,
            "Node type missmatched {$expected->nodeType} expected, {$result->nodeType} received. " . $this->getNodeInfo( $expected, $result, $level )
        );
        $this->assertEquals(
            $expected->localName,
            $result->localName,
            "Local name missmatched {$expected->localName} expected, {$result->localName} received. " . $this->getNodeInfo( $expected, $result, $level )
        );
        $this->assertEquals(
            $expected->namespaceURI,
            $result->namespaceURI,
            "Namespace URI missmatched {$expected->namespaceURI} expected, {$result->namespaceURI} received. " . $this->getNodeInfo( $expected, $result, $level )
        );

        switch ( $expected->nodeType )
        {
            case XML_ELEMENT_NODE:
                if ( $expected->childNodes->length !== 0 )
                {
                    // Text content for elements with children might differ
                    break;
                }
            case XML_ATTRIBUTE_NODE:
            case XML_TEXT_NODE:
                $this->assertEquals(
                    trim( $expected->nodeValue ),
                    trim( $result->nodeValue ),
                    "Node value missmatched {$expected->nodeValue} expected, {$result->nodeValue} received. " . $this->getNodeInfo( $expected, $result, $level )
                );
                break;
        }

        if ( $expected->hasChildNodes() )
        {
            $this->assertEquals(
                $expected->childNodes->length,
                $result->childNodes->length,
                "Expected number of children missmatched {$expected->childNodes->length} expected, {$result->childNodes->length} received. " . $this->getNodeInfo( $expected, $result, $level )
            );
        }
    }

    protected function getNodeInfo( DOMNode $expected, DOMNode $result, $level )
    {
        $parentExpectedElement = $this->getParentDomElement( $expected );
        $parentResultElement = $this->getParentDomElement( $result );

        $expectedDom = new DOMDocument();
        $expectedImported = $expectedDom->importNode( $parentExpectedElement, true );
        $expectedDom->appendChild( $expectedImported );

        $resultDom  = new DOMDocument();
        $resultImported = $resultDom->importNode( $parentResultElement, true );
        $resultDom->appendChild( $resultImported );

        return "Nesting level: $level."
            . " Node info: Expected node: {$expected->localName} ({$expected->nodeType}). "
            . "Received: {$result->localName} ({$result->nodeType})."
            . "\n\nExpected:\n" . $expectedDom->saveXml()
            . "\n\nActual:\n" . $resultDom->saveXml()
        ;
    }

    protected function getParentDomElement( DOMNode $node )
    {
        if ( $node->nodeType === XML_ELEMENT_NODE )
        {
            return $node;
        }
        return $this->getParentDomElement( $node->parentNode );
    }
}

?>
