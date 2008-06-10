<?php
/**
 * File containing the ezcSearchZendLuceneHandler class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */

/**
 * ZendLucene backend implementation
 *
 * @package Search
 * @version //autogentag//
 * @ignore
 */
class ezcSearchZendLuceneHandler implements ezcSearchHandler, ezcSearchIndexHandler
{
    /**
     * Holds the connection to ZendLucene
     *
     * @var resource(stream)
     */
    public $connection;

    /**
     * Hosts the hostname of the zendlucene server
     *
     * @var string
     */
    private $host;

    /**
     * Hosts the port number of the zendlucene server
     *
     * @var int
     */
    private $port;

    /**
     * Hosts the location of the interface on the zendlucene server
     *
     * @var string
     */
    private $location;

    /**
     * Stores the transaction nesting depth.
     *
     * @var integer
     */
    private $inTransaction;

    /**
     * Creates a new ZendLucene handler connection
     *
     * @param string $location
     */
    public function __construct( $location = '/tmp/lucene' )
    {
        $this->connection = Zend_Search_Lucene::create( $location );
        $this->inTransaction = 0;
        if ( !$this->connection )
        {
            throw new ezcSearchCanNotConnectException( 'zendlucene', $location );
        }

    }

    /**
     * Starts a transaction for indexing.
     *
     * When using a transaction, the amount of processing that zendlucene does
     * decreases, increasing indexing performance. Without this, the component
     * sends a commit after every document that is indexed. Transactions can be
     * nested, when commit() is called the same number of times as
     * beginTransaction(), the component sends a commit.
     */
    public function beginTransaction()
    {
    }

    /**
     * Ends a transaction and calls commit.
     *
     * As transactions can be nested, this method will only call commit when
     * all the nested transactions have been ended.
     *
     * @throws ezcSearchTransactionException if no transaction is active.
     */
    public function commit()
    {
        $this->connection->optimize();
    }

    /**
     * Builds query parameters from the different query fields
     *
     * @param string $queryWord
     * @param string $defaultField
     * @param array(string=>string) $searchFieldList
     * @param array(string=>string) $returnFieldList
     * @param array(string=>string) $highlightFieldList
     * @param array(string=>string) $facetFieldList
     * @param int    $limit
     * @param int    $offset
     * @param array(string=>string) $order
     * @return array
     */
    private function buildQuery( $queryWord, $defaultField, $searchFieldList = array(), $returnFieldList = array(), $highlightFieldList = array(), $facetFieldList = array(), $limit = null, $offset = false, $order = array() )
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
            $queryFlags['hl.snippets'] = 3;
            $queryFlags['hl.fl'] = join( ' ', $highlightFieldList );
            $queryFlags['hl.simple.pre'] = '<b>';
            $queryFlags['hl.simple.post'] = '</b>';
        }
        if ( count( $facetFieldList ) )
        {
            $queryFlags['facet'] = 'true';
            $queryFlags['facet.mincount'] = 1;
            $queryFlags['facet.sort'] = 'false';
            $queryFlags['facet.field'] = join( ' ', $facetFieldList );
        }
        if ( count( $order ) )
        {
            $sortFlags = array();
            foreach ( $order as $column => $type )
            {
                if ( $type == ezcSearchQueryTools::ASC )
                {
                    $sortFlags[] = "$column asc";
                }
                else
                {
                    $sortFlags[] = "$column desc";
                }
            }
            $queryFlags['sort'] = join( ', ', $sortFlags );
        }
        $queryFlags['start'] = $offset;
        $queryFlags['rows'] = $limit === null ? 999999 : $limit;

//        Zend_Search_Lucene::setResultSetLimit( $offset + $limit );
        return $queryFlags;
    }

    /**
     * Converts a raw zendlucene result into a document using the definition $def
     *
     * @param ezcSearchQuery $query
     * @param mixed $response
     * @return ezcSearchResult
     */
    private function createResponseFromData( ezcSearchQuery $query, $response )
    {
        $def = $query->getDefinition();
        $s = new ezcSearchResult();
        $s->resultCount = count( $response );

        $counter = 0;

        foreach ( $response as $hit )
        {
            if ( $query->offset < $counter )
            {
                continue;
            }
            $counter++;
            if ( $counter > $query->limit )
            {
                break;
            }
            $document = $hit->getDocument();

            $className = $def->documentType;
            $obj = new $className;

            $attr = array();
            foreach ( $def->fields as $field )
            {
                $fieldName = $this->mapFieldType( $field->field, $field->type );
                if ( $field->inResult /*&& isset( $document->$fieldName )*/ )
                {
                    $attr[$field->field] = $this->mapFieldValuesForReturn( $field, $document->$fieldName );
                }
            }
            $obj->setState( $attr );

            $idProperty = $def->idProperty;
            $s->documents[$attr[$idProperty]] = array( 'meta' => array( 'score' => $hit->score ), 'document' => $obj );
        }

        // process highlighting
        if ( isset( $response->highlighting ) && count( $s->documents ) )
        {
            foreach ( $s->documents as $id => &$document )
            {
                $document['highlight'] = array();
                if ( isset( $response->highlighting->$id ) )
                {
                    foreach ( $def->fields as $field )
                    {
                        $fieldName = $this->mapFieldType( $field->field, $field->type );
                        if ( $field->highlight && isset( $response->highlighting->$id->$fieldName ) )
                        {
                            $document['highlight'][$field->field] = $response->highlighting->$id->$fieldName;
                        }
                    }
                }
            }
        }

        // process facets
        if ( isset( $response->facet_counts ) && isset( $response->facet_counts->facet_fields ) )
        {
            $facets = $response->facet_counts->facet_fields;
            foreach ( $def->fields as $field )
            {
                $fieldName = $this->mapFieldType( $field->field, $field->type );
                if ( isset( $facets->$fieldName ) )
                {
                    // sigh, stupid array format needs fixing
                    $facetValues = array();
                    $facet = $facets->$fieldName;
                    for ( $i = 0; $i < count( $facet ); $i += 2 )
                    {
                        $facetValues[$facet[$i]] = $facet[$i+1];
                    }
                    $s->facets[$field->field] = $facetValues;
                }
            }
        }

        return $s;
    }

    /**
     * Executes a search by building and sending a query and returns the raw result
     *
     * @param string $queryWord
     * @param string $defaultField
     * @param array(string=>string) $searchFieldList
     * @param array(string=>string) $returnFieldList
     * @param array(string=>string) $highlightFieldList
     * @param array(string=>string) $facetFieldList
     * @param int    $limit
     * @param int    $offset
     * @param array(string=>string) $order
     * @return stdClass
     */
    public function search( $queryWord, $defaultField, $searchFieldList = array(), $returnFieldList = array(), $highlightFieldList = array(), $facetFieldList = array(), $limit = null, $offset = 0, $order = array() )
    {
        /*
        $result = $this->sendRawGetCommand( 'select', $this->buildQuery( $queryWord, $defaultField, $searchFieldList, $returnFieldList, $highlightFieldList, $facetFieldList, $limit, $offset, $order ) );
        $result = json_decode( $result );
        */
        $query = $this->buildQuery( $queryWord, $defaultField, $searchFieldList, $returnFieldList, $highlightFieldList, $facetFieldList, $limit, $offset, $order );
//        $query = new Zend_Search_Lucene_Search_Query_Term( new Zend_Search_Lucene_Index_Term( 'article', 'title' ) );
        $args = array();
        $args[] = $query['q'];

        if ( is_array( $order ) )
        {
            foreach ( $order as $field => $sort )
            {
                $args[] = $field;
                $args[] = SORT_REGULAR;
                $args[] = $sort == ezcSearchQueryTools::ASC ? SORT_ASC : SORT_DESC;
            }
        }

        $result = call_user_func_array( array( $this->connection, 'find' ), $args );
        return $result;
    }

    /**
     * Returns 'zendlucene'.
     *
     * @return string
     */
    static public function getName()
    {
        return 'zendlucene';
    }

    /**
     * Creates a search query object with the fields from the definition filled in.
     *
     * @param string $type
     * @param ezcSearchDocumentDefinition $definition
     * @return ezcSearchFindQuery
     */
    public function createFindQuery( $type, ezcSearchDocumentDefinition $definition )
    {
        $query = new ezcSearchQueryZendLucene( $this, $definition );
        $query->select( 'score' );
        if ( $type )
        {
            $selectFieldNames = array();
            foreach ( $definition->getSelectFieldNames() as $docProp )
            {
                $selectFieldNames[] = $this->mapFieldType( $docProp, $definition->fields[$docProp]->type );
            }
            $highlightFieldNames = array();
            foreach ( $definition->getHighlightFieldNames() as $docProp )
            {
                $highlightFieldNames[] = $this->mapFieldType( $docProp, $definition->fields[$docProp]->type );
            }
            $query->select( $selectFieldNames );
            $query->where( $query->eq( 'ezcsearch_type', $type ) );
            $query->highlight( $highlightFieldNames );
        }
        return $query;
    }

    /**
     * Builds the search query and returns the parsed response
     *
     * @param ezcSearchFindQuery $query
     * @return ezcSearchResult
     */
    public function find( ezcSearchFindQuery $query )
    {
        $queryWord = join( ' AND ', $query->whereClauses );
        $resultFieldList = $query->resultFields;
        $highlightFieldList = $query->highlightFields;
        $facetFieldList = $query->facets;
        $limit = $query->limit;
        $offset = $query->offset;
        $order = $query->orderByClauses;

        $res = $this->search( $queryWord, '', array(), $resultFieldList, $highlightFieldList, $facetFieldList, $limit, $offset, $order );
        return $this->createResponseFromData( $query, $res );
    }

    /**
     * Returns the query as a string for debugging purposes
     *
     * @param ezcSearchQueryZendLucene $query
     * @return string
     * @ignore
     */
    public function getQuery( ezcSearchQueryZendLucene $query )
    {
        $queryWord = join( ' AND ', $query->whereClauses );
        $resultFieldList = $query->resultFields;
        $highlightFieldList = $query->highlightFields;
        $facetFieldList = $query->facets;
        $limit = $query->limit;
        $offset = $query->offset;
        $order = $query->orderByClauses;

        $query = $this->buildQuery( $queryWord, '', array(), $resultFieldList, $highlightFieldList, $facetFieldList, $limit, $offset, $order );
        return $query['q'];
    }

    /**
     * Returns the field name as used by zendlucene created from the field $name and $type.
     *
     * @param string $name
     * @param string $type
     * @return string
     */
    public function mapFieldType( $name, $type )
    {
        return $name;
    }

    /**
     * This method prepares a $value before it is passed to the indexer.
     *
     * Depending on the $fieldType the $value is modified so that the indexer understands the value.
     *
     * @param string $fieldType
     * @param mixed $value
     * @return mixed
     */
    public function mapFieldValueForIndex( $fieldType, $value )
    {
        switch ( $fieldType )
        {
            case ezcSearchDocumentDefinition::DATE:
                if ( is_numeric( $value ) )
                {
                    $d = new DateTime( "@$value" );
                    $value = $d->format( 'U' );
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
                    $value = $d->format( 'U' );
                }
                break;

            case ezcSearchDocumentDefinition::BOOLEAN:
                $value = $value ? 'true' : 'false';
                break;
        }
        return $value;
    }

    /**
     * This method prepares a $value before it is passed to the search handler.
     *
     * Depending on the $fieldType the $value is modified so that the search
     * handler understands the value.
     *
     * @param string $fieldType
     * @param mixed $value
     * @return mixed
     */
    public function mapFieldValueForSearch( $fieldType, $value )
    {
        switch ( $fieldType )
        {
            case ezcSearchDocumentDefinition::STRING:
            case ezcSearchDocumentDefinition::TEXT:
            case ezcSearchDocumentDefinition::HTML:
                $value = trim( $value );
                if ( strpbrk( $value, ' "' ) !== false )
                {
                    $value = '"' . str_replace( '"', '\"', $value ) . '"';
                }
                break;

            case ezcSearchDocumentDefinition::INT:
            case ezcSearchDocumentDefinition::FLOAT:
                $value = '"' . $value . '"';
                break;

            case ezcSearchDocumentDefinition::DATE:
                if ( is_numeric( $value ) )
                {
                    $d = new DateTime( "@$value" );
                    $value = $d->format( 'U' );
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
                    $value = $d->format( 'U' );
                }
                break;

            case ezcSearchDocumentDefinition::BOOLEAN:
                $value = ($value ? 'true' : 'false');
                break;
        }
        return $value;
    }

    /**
     * This method prepares a $value before it is passed to the search handler.
     *
     * Depending on the $fieldType the $value is modified so that the search
     * handler understands the value.
     *
     * @param string $fieldType
     * @param mixed $value
     * @return mixed
     */
    public function mapFieldValueForReturn( $fieldType, $value )
    {
        switch ( $fieldType )
        {
            case ezcSearchDocumentDefinition::BOOLEAN:
                $value = $value == 'true' ? true : false;
                break;

            case ezcSearchDocumentDefinition::DATE:
                $value = new DateTime( "@$value" );
                break;

        }
        return $value;
    }

    /**
     * This method prepares a value or an array of $values before it is passed to the search handler.
     *
     * Depending on the $field the $values is modified so that the search
     * handler understands the value. It will also correctly deal with
     * multi-data fields in the search index.
     *
     * @throws ezcSearchInvalidValueException if an array of values is
     *         submitted, but the field has not been defined as a multi-value field.
     *
     * @param ezcSearchDocumentDefinitionField $field
     * @param mixed $values
     * @return array(mixed)
     */
    public function mapFieldValuesForSearch( $field, $values )
    {
        if ( is_array( $values ) && $field->multi == false )
        {
            throw new ezcSearchInvalidValueException( $field->type, $values, 'multi' );
        }
        if ( !is_array( $values ) )
        {
            $values = array( $values );
        }
        foreach ( $values as &$value )
        {
            $value = $this->mapFieldValueForSearch( $field->type, $value );
        }
        return $values;
    }

    /**
     * This method prepares a value or an array of $values before it is passed to the indexer.
     *
     * Depending on the $field the $values is modified so that the search
     * handler understands the value. It will also correctly deal with
     * multi-data fields in the search index.
     *
     * @throws ezcSearchInvalidValueException if an array of values is
     *         submitted, but the field has not been defined as a multi-value field.
     *
     * @param ezcSearchDocumentDefinitionField $field
     * @param mixed $values
     * @return array(mixed)
     */
    public function mapFieldValuesForIndex( $field, $values )
    {
        if ( is_array( $values ) && $field->multi == false )
        {
            throw new ezcSearchInvalidValueException( $field->type, $values, 'multi' );
        }
        if ( !is_array( $values ) )
        {
            $values = array( $values );
        }
        foreach ( $values as &$value )
        {
            $value = $this->mapFieldValueForIndex( $field->type, $value );
        }
        return $values;
    }

    /**
     * This method prepares a value or an array of $values after it has been returned by search handler.
     *
     * Depending on the $field the $values is modified.  It will also correctly
     * deal with multi-data fields in the search index.
     *
     * @param ezcSearchDocumentDefinitionField $field
     * @param mixed $values
     * @return mixed|array(mixed)
     */
    public function mapFieldValuesForReturn( $field, $values )
    {
        $values = $this->mapFieldValueForReturn( $field->type, $values );
        return $values;
    }

    /**
     * Runs a commit command to tell zendlucene we're done indexing.
     */
    protected function runCommit()
    {
        $r = $this->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );
    }

    /**
     * Indexes the document $document using definition $definition
     *
     * @param ezcSearchDocumentDefinition $definition
     * @param mixed $document
     */
    public function index( ezcSearchDocumentDefinition $definition, $document )
    {
        $doc = new Zend_Search_Lucene_Document();

        $doc->addField( Zend_Search_Lucene_Field::Text( 'ezcsearch_type', $definition->documentType ) );
        foreach ( $definition->fields as $field )
        {
            $values = $this->mapFieldValuesForIndex( $field, $document[$field->field] );
//            $xml->writeAttribute( 'name', $this->mapFieldType( $field->field, $field->type ) );a
            foreach ( $values as $value )
            {
                switch ( $field->type )
                {
                    case ezcSearchDocumentDefinition::INT:
                    case ezcSearchDocumentDefinition::DATE:
                    case ezcSearchDocumentDefinition::STRING:
                        $doc->addField( Zend_Search_Lucene_Field::Keyword( $field->field, $value ) );
                        break;

                    default:
                        $doc->addField( Zend_Search_Lucene_Field::Text( $field->field, $value ) );
                }
            }
        }
        $this->connection->addDocument( $doc );
    }

    /**
     * Creates a delete query object with the fields from the definition filled in.
     *
     * @param string $type
     * @return ezcSearchDeleteQuery
     */
    public function createDeleteQuery( $type )
    {
    }

    /**
     * Builds the delete query and returns the parsed response
     *
     * @param ezcSearchDeleteQuery $query
     * @return ezcSearchResult
     */
    public function delete( ezcSearchDeleteQuery $query )
    {
    }
}
?>
