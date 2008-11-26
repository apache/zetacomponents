<?php
class TestHandler extends ezcSearchSolrHandler
{
    public function __construct( $host = 'localhost', $port = 8983, $location = '/solr' )
    {
    }
}

class BuildQueryQuery extends ezcSearchQueryBuilder
{
    static public function tokenize( $string )
    {
        return parent::tokenize( $string );
    }
}

class MissingID implements ezcSearchDefinitionProvider
{
    static function getDefinition()
    {
        $d = new ezcSearchDocumentDefinition( 'MissingID' );
        $d->fields['title'] = new ezcSearchDefinitionDocumentField( 'title' );
        return $d;
    }
}

class UnknownType
{
}

class EmbeddedArticle implements ezcSearchDefinitionProvider
{
    static function getDefinition()
    {
        $d = new ezcSearchDocumentDefinition( 'MissingID' );
        $d->fields['id'] = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::STRING );
        $d->fields['title'] = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::STRING, 2 );
        $d->fields['summary'] = new ezcSearchDefinitionDocumentField( 'summary', ezcSearchDocumentDefinition::TEXT );
        $d->fields['body'] = new ezcSearchDefinitionDocumentField( 'body', ezcSearchDocumentDefinition::HTML, 1, false );
        $d->fields['published'] = new ezcSearchDefinitionDocumentField( 'published', ezcSearchDocumentDefinition::DATE );
        $d->idProperty = 'id';
        return $d;
    }
}

class DataTypeTest implements ezcSearchDefinitionProvider
{
    public function __construct( $id = null, $string = null, $html = null, $bool = null, $int = null, $float = null, $date = null )
    {
        $this->id = $id; $this->string = $string; $this->html = $html;
        $this->bool = $bool; $this->int = $int; $this->float = $float;
        $this->date = $date;
    }

    function getState()
    {
        return array(
            'id' => $this->id, 'string' => $this->string, 'html' =>
            $this->html, 'bool' => $this->bool, 'int' => $this->int, 'float' =>
            $this->float, 'date' => $this->date,
        );
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    static public function getDefinition()
    {
        $def = new ezcSearchDocumentDefinition( 'DataTypeTest' );
        $def->idProperty = 'id';
        $def->fields['id'] =     new ezcSearchDefinitionDocumentField( 'id',     ezcSearchDocumentDefinition::STRING );
        $def->fields['string'] = new ezcSearchDefinitionDocumentField( 'string', ezcSearchDocumentDefinition::STRING );
        $def->fields['html'] =   new ezcSearchDefinitionDocumentField( 'html',   ezcSearchDocumentDefinition::HTML );
        $def->fields['bool'] =   new ezcSearchDefinitionDocumentField( 'bool',   ezcSearchDocumentDefinition::BOOLEAN );
        $def->fields['int'] =    new ezcSearchDefinitionDocumentField( 'int',    ezcSearchDocumentDefinition::INT );
        $def->fields['float'] =  new ezcSearchDefinitionDocumentField( 'float',  ezcSearchDocumentDefinition::FLOAT );
        $def->fields['date'] =   new ezcSearchDefinitionDocumentField( 'date',   ezcSearchDocumentDefinition::DATE );

        return $def;
    }
}

class DataTypeTestMulti implements ezcSearchDefinitionProvider
{
    public function __construct( $id = null, $string = null, $html = null, $bool = null, $int = null, $float = null, $date = null )
    {
        $this->id = $id; $this->string = $string; $this->html = $html;
        $this->bool = $bool; $this->int = $int; $this->float = $float;
        $this->date = $date;
    }

    function getState()
    {
        return array(
            'id' => $this->id, 'string' => $this->string, 'html' =>
            $this->html, 'bool' => $this->bool, 'int' => $this->int, 'float' =>
            $this->float, 'date' => $this->date,
        );
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    static public function getDefinition()
    {
        $def = new ezcSearchDocumentDefinition( 'DataTypeTestMulti' );
        $def->idProperty = 'id';
        $def->fields['id'] =     new ezcSearchDefinitionDocumentField( 'id',     ezcSearchDocumentDefinition::STRING );
        $def->fields['string'] = new ezcSearchDefinitionDocumentField( 'string', ezcSearchDocumentDefinition::STRING,  1, true, true );
        $def->fields['html'] =   new ezcSearchDefinitionDocumentField( 'html',   ezcSearchDocumentDefinition::HTML,    1, true, true );
        $def->fields['bool'] =   new ezcSearchDefinitionDocumentField( 'bool',   ezcSearchDocumentDefinition::BOOLEAN, 1, true, true );
        $def->fields['int'] =    new ezcSearchDefinitionDocumentField( 'int',    ezcSearchDocumentDefinition::INT,     1, true, true );
        $def->fields['float'] =  new ezcSearchDefinitionDocumentField( 'float',  ezcSearchDocumentDefinition::FLOAT,   1, true, true );
        $def->fields['date'] =   new ezcSearchDefinitionDocumentField( 'date',   ezcSearchDocumentDefinition::DATE,    1, true, true );

        return $def;
    }
}

class testSolrFileWrapper extends ezcSearchSolrHandler
{
    function __construct( $fileName )
    {
        $this->host = 'localhost';
        $this->port = '8983';
        $this->location = $fileName;
        $this->inTransaction = 0;
        $this->connect();
    }

    function connect()
    {
        $this->connection = fopen( $this->location, 'r+' );
        stream_filter_append( $this->connection, 'ignoreWriteFilter', STREAM_FILTER_WRITE );
    }
}

class ezcTestIgnoreWriteStreamFilter
{
    function filter( $in, $out, &$consumed, $closing )
    {
        while ( $bucket = stream_bucket_make_writeable( $in ) )
        {
            $consumed += 0;
        }
        return PSFS_PASS_ON;
    }
}
?>
