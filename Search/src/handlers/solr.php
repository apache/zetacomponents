<?php
/**
 * File containing the ezcSearchSolrHandler class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Solr backend implementation
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchSolrHandler implements ezcSearchHandler, ezcSearchIndexHandler
{
    /**
     * Holds the connection to Solr
     *
     * @var resource(stream)
     */
    public $connection;

    public $host;
    public $port;
    public $location;

    /**
     * Creates a new Solr handler connection
     *
     * @param string
     */
    public function __construct( $host = 'localhost', $port = 8983, $location = '/solr' )
    {
        $this->host = $host;
        $this->port = $port;
        $this->location = $location;
        $this->connection = @stream_socket_client( "tcp://{$this->host}:{$this->port}" );
        if ( !$this->connection )
        {
            throw new ezcSearchCanNotConnectException( 'solr', "http://{$this->host}:{$this->port}{$this->location}" );
        }

    }

    public function getLine( $maxLength = false )
    {
        $line = ''; $data = '';
        while ( strpos( $line, "\n" ) === false )
        {
            $line = fgets( $this->connection, $maxLength ? $maxLength + 1: 512 );

            /* If solr aborts the connection, fgets() will
             * return false. We need to throw an exception here to prevent
             * the calling code from looping indefinitely. */
            if ( $line === false )
            {
                $this->connection = null;
                throw new ezcSearchNetworkException( 'Could not read from the stream. It was probably terminated by the host.' );
            }

            $data .= $line;
            if ( strlen( $data ) >= $maxLength )
            {
                break;
            }
        }
        return $data;
    }

    public function sendRawGetCommand( $type, $queryString = array() )
    {
        $queryPart = '';
        if ( count( $queryString ) )
        {
            $queryPart = '/?'. http_build_query( $queryString );
        }
        $cmd =  "GET {$this->location}/{$type}{$queryPart} HTTP/1.1\n";
        $cmd .= "Host {$this->host}:{$this->port}\n";
        $cmd .= "User-Agent: eZ Components Search\n";
        $cmd .= "\n";

        fwrite( $this->connection, $cmd );

        // read http header
        $line = '';
        $chunked = false;
        while ( $line != "\r\n" )
        {
            $line = $this->getLine();
            if ( preg_match( '@Content-Length: (\d+)@', $line, $m ) )
            {
                $expectedLength = $m[1];
            }

            if ( preg_match( '@Transfer-Encoding: chunked@', $line ) )
            {
                $chunked = true;
            }
        }

        $data = '';
        $chunkLength = -1;
        // read http content with chunked encoding
        if ( $chunked )
        {
            while ( $chunkLength !== 0 )
            {
                // fetch chunk length
                $line = $this->getLine();
                $chunkLength = hexdec( $line );

                $size = 1;
                while ( $size < $chunkLength )
                {
                    $line = $this->getLine( $chunkLength );
                    $size += strlen( $line );
                    $data .= $line;
                }
                $line = $this->getLine();
            }
        }
        else // without chunked encoding
        {
            $size = 1;
            while ( $size < $expectedLength )
            {
                $line = $this->getLine( $expectedLength );
                $size += strlen( $line );
                $data .= $line;
            }
        }
        return $data;
    }

    public function sendRawPostCommand( $type, $queryString, $data )
    {
        $queryPart = '';
        if ( count( $queryString ) )
        {
            $queryPart = '/?'. http_build_query( $queryString );
        }
        $length = strlen( $data );
        $cmd =  "Post {$this->location}/{$type}{$queryPart} HTTP/1.1\n";
        $cmd .= "Host {$this->host}:{$this->port}\n";
        $cmd .= "User-Agent: eZ Components Search\n";
        $cmd .= "Content-Type: text/xml\n";
        $cmd .= "Content-Length: $length\n";
        $cmd .= "\n";
        $cmd .= $data;

        fwrite( $this->connection, $cmd );

        // read http header
        $line = '';
        while ( $line != "\r\n" )
        {
            $line = $this->getLine();
            if ( preg_match( '@Content-Length: (\d+)@', $line, $m ) )
            {
                $expectedLength = $m[1];
            }
        }

        // read http content
        $size = 1;
        $data = '';
        while ( $size < $expectedLength )
        {
            $line = $this->getLine( $expectedLength );
            $size += strlen( $line );
            $data .= $line;
        }
        return $data;
    }

    public function search( $queryWord, $defaultField, $searchFieldList = array(), $returnFieldList = array(), $highlightFieldList = array() )
    {
        if ( count( $searchFieldList ) > 0 )
        {
            $queryString = '';
            foreach ( $searchFieldList as $searchField )
            {
                $queryString .= "$searchField:$queryWord ";
            }
        }
        else
        {
            $queryString = $queryWord;
        }
        $queryFlags = array( 'q' => $queryString, 'wt' => 'json', 'df' => $defaultField );
        if ( count( $returnFieldList ) )
        {
            $returnFieldList[] = 'score';
            $queryFlags['fl'] = join( ' ', $returnFieldList );
        }
        if ( count( $highlightFieldList ) )
        {
            $queryFlags['hl'] = 'true';
            $queryFlags['hl.snippets'] = 10;
            $queryFlags['hl.fl'] = join( ' ', $highlightFieldList );
        }

        $result = $this->sendRawGetCommand( 'select', $queryFlags );
        $result = json_decode( $result );
        return ezcSearchResult::createFromResponse( $result );
    }

    /**
     * Returns 'solr'.
     *
     * @return string
     */
    static public function getName()
    {
        return 'solr';
    }

    public function createFindQuery( $type = false )
    {
    }

    public function find( ezcSearchFindQuery $query )
    {
    }

    private function mapFieldType( $name, $type )
    {
        $map = array(
            ezcSearchDocumentDefinition::STRING => '_s',
            ezcSearchDocumentDefinition::TEXT => '_t',
            ezcSearchDocumentDefinition::HTML => '_t',
            ezcSearchDocumentDefinition::DATE => '_dt',
        );
        return $name . $map[$type];
    }

    private function mapFieldValue( $field, $values )
    {
        if ( !is_array( $values ) )
        {
            $values = array( $values );
        }
        foreach ( $values as &$value )
        {
            switch( $field->type )
            {
                case ezcSearchDocumentDefinition::DATE:
                    if ( is_numeric( $value ) )
                    {
                        $d = new DateTime( "@$value" );
                        $value = $d->format( 'Y-m-d\TH:i:s\Z' );
                    }
                    else
                    {
                        try
                        {
                            $d = new DateTime( $value );
                        }
                        catch ( Exception $e )
                        {
                            throw new ezcSearchInvalidValueException( $type, $value );
                        }
                        $value = $d->format( 'Y-m-d\TH:i:s\Z' );
                    }
            }
        }
        return $values;
    }

    public function index( ezcSearchDocumentDefinition $definition, $document )
    {
        $xml = new XmlWriter();
        $xml->openMemory();
        $xml->startElement( 'add' );
        $xml->startElement( 'doc' );
        $xml->startElement( 'field' );
        $xml->writeAttribute( 'name', 'id' );
        $xml->text( $document[$definition->idProperty] );
        $xml->endElement();
        foreach ( $definition->fields as $field )
        {
            $value = $this->mapFieldValue( $field, $document[$field->field] );
            foreach ( $value as $fieldValue )
            {
                $xml->startElement( 'field' );
                $xml->writeAttribute( 'name', $this->mapFieldType( $field->field, $field->type ) );
                $xml->text( $fieldValue );
                $xml->endElement();
            }
        }
        $xml->endElement();
        $xml->endElement();
        $doc = $xml->outputMemory( true );

        $r = $this->sendRawPostCommand( 'update', array( 'wt' => 'json' ), $doc );
        $r = $this->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );
    }

    public function createDeleteQuery()
    {
    }

    public function delete( ezcSearchDeleteQuery $query )
    {
    }
}
?>
