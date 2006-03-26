<?php
/**
 * File containing the XMLWriter class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for files containing PHP arrays that represent DB schema.
 *
 * @package DatabaseSchema
 * @access private
 */
class XMLWriter
{
    private $elementStack;
    private $uriFs = false;
    
    public function __construct()
    {
        $this->elementStack = array();
    }

    public function openUri( $filename )
    {
        $this->uriFs = fopen( $filename, 'w' );
    }

    public function startDocument( $version, $charset = 'utf-8' )
    {
        fputs( $this->uriFs, "<?xml version='$version' encoding='$charset' ?>\n" );
    }

    public function startElement( $name )
    {
        fputs( $this->uriFs, "<$name>" );
        array_push( $this->elementStack, $name );
    }

    public function endElement()
    {
        $name = array_pop( $this->elementStack );
        fputs( $this->uriFs, "</$name>" );
    }

    public function text( $text )
    {
        fputs( $this->uriFs, $text );
    }

    public function endDocument()
    {
        fclose( $this->uriFs );
    }

    public function flush()
    {
        fputs( $this->uriFs, "\n" );
    }
}
?>
