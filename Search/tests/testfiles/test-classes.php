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
?>
