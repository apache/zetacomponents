<?php
/**
 * File containing the ezcDbSchemaHandlerXml class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for XML files.
 *
 * NOTE: Install XMLReader extension
 * if you want to perform bulk data transfers to/from XML files.
 *
 * @package DatabaseSchema
 */

class ezcDbSchemaHandlerXml extends ezcDbSchemaHandler implements ezcDbSchemaHandlerDataTransfer
{
    private $currentTableBeingStored = null;
    private $storeFileHandler;

    static private $XmlCharTransTable = null;
    static private $XmlCharTransTableReverse = null;

    /**
     * Constructor.
     *
     * @param array $params Handler parameters. See {@link ezcDbSchemaHandler}.
     */
    public function __construct( $params )
    {
        parent::__construct( $params );

        // FIXME: do something really smart regarding charsets
        $trans = get_html_translation_table( HTML_ENTITIES, ENT_NOQUOTES );
        foreach ( $trans as $k => $v )
            $trans[$k] = "&#".ord($k).";";
        self::$XmlCharTransTable        = $trans;
        self::$XmlCharTransTableReverse = array_flip( $trans );
    }

    /**
     * This handler supports saving/loading schema
     * to/from XML files.
     */
    static public function getSupportedStorageTypes()
    {
        return array( 'xml-file' );
    }

    /**
     * @return array List of schema features supported by the handler.
     */
    static public function getSupportedFeatures()
    {
        return array();
    }

    /**
     * @see ezcDbSchemaHandler::needsSchemaTransformation()
     */
    public function needsSchemaTransformation()
    {
        return false;
    }

    /**
     * Load schema from an .xml file.
     */
    public function loadSchema( $src, $storageType, $what )
    {
        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to load.' );
        }

        $processSchema = $this->processSchema( $what );
        $processData   = $this->processData( $what );

        if ( !$processSchema && !$processData )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMMENT,
                                            'Nothing to load.' );
        }

        if ( !file_exists( $src ) )
            throw new ezcDbSchemaException( ezcDbSchemaException::FILE_NOT_FOUND );

        $dom = DOMDocument::load( $src );
        $schema = self::transformDomToArray( $dom, $processSchema, $processData );
        return $schema;
    }

    /**
     * Save schema to an .xml file.
     */
    public function saveSchema( $schema, $dst, $storageType, $what )
    {
        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to save.' );
        }

        $processSchema = $this->processSchema( $what );
        $processData   = $this->processData( $what );

        if ( !$processSchema && !$processData )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMMENT,
                                            'Nothing to save.' );
        }

        $dom = self::transformArrayToDom( $schema, $processSchema, $processData );
        $dom->save( $dst );
    }

    /**
     * Saves difference between schemas to file.
     */
    public function saveDelta ( $delta, $dst, $storageType )
    {
    }

    /**
     * Returns the list of internal formats supported by the handler.
     */
    static public function getSupportedInternalFormats()
    {
        return array( 'xml-string', 'xml-domtree' );
    }

    /**
     * Return schema in one of internal formats without saving it to a file or database.
     *
     * @see ezcDbSchemaHandler::getSchema()
     */
    public function getSchema( $schema, $internalFormat, $what )
    {
        // check what the result is expected to contain: schema, data or both
        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to  get.' );
        }

        $processSchema = $this->processSchema( $what );
        $processData   = $this->processData( $what );

        if ( !$processSchema && !$processData )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMMENT,
                                            'Nothing to get.' );
        }

        // transform schema array to DOM tree
        $dom = self::transformArrayToDom( $schema, $processSchema, $processData );

        // Remove unwanted info from the tree.
        $elRoot = $dom->documentElement;
        $elementsToRemove = array();
        if ( !$processSchema )
            $elementsToRemove[] = 'schema';
        if ( !$processData )
            $elementsToRemove[] = 'data';
        foreach ( $elementsToRemove as $name )
        {
            $el = $elRoot->getElementsByTagName( $name )->item( 0 );
            if ( !is_null( $el ) )
            {
                $elRoot->removeChild( $el );
            }
        }

        switch ( $internalFormat )
        {
            case 'xml-string':
                return $dom->saveXML(); // the tree is transformed to string here
            case 'xml-domtree':
                return $dom;
        }

        return false;
    }

    /**
     * Transform the schema given as PHP-array to DOM tree.
     *
     * @return DOMDocument The resulting DOM.
     */
    private static final function transformArrayToDom( $schema, $processSchema, $processData )
    {
        $doc = new DOMDocument( '1.0', 'utf-8' );
        $elRoot = $doc->appendChild( $doc->createElement( 'ezcDatabaseSchema' ) );
        self::appendNewLine( $elRoot );

        if ( $processSchema )
        {
            if ( !isset( $schema['schema'] )  )
            {
                throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                                'You should load schema before using it.' );
            }

            $elSchema = self::transformArraySchemaToDom( $doc, $schema['schema'] );
            $elRoot->appendChild( $elSchema );
            self::appendNewLine( $elRoot );
        }

        if ( $processData )
        {
            if ( !isset( $schema['data'] )  )
            {
                throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                                'You should load data before using it.' );
            }

            $elData = self::transformArrayDataToDom( $doc, $schema['data'] );
            $elRoot->appendChild( $elData );
            self::appendNewLine( $elRoot );
        }

        return $doc;
    }

    /**
     * Recursively dump an arbitrary data structure to DOM tree.
     *
     * @param DOMElement $parent Parent DOM element.
     * @param string     $name   Element name for the value being dumped.
     * @param mixed      $value  The value to dump.
     * @param int    $initialiIndent Initial indentation level.
     */
    private static final function transformVarToDomElement( $parent, $name, $value, $initialIndent = 0 )
    {
        self::appendNewLine( $parent );
        self::appendIndent( $parent, $initialIndent+1 );
        $elVar = $parent->appendChild( new DOMElement( 'var' ) );
        $elVar->setAttribute( 'name', $name );
        $valueType = gettype( $value );

        switch ( $valueType )
        {
            case 'integer':
            case 'double':
            case 'string':
                $elVar->setAttribute( 'type', $valueType );
                $elVar->setAttribute( 'value', $value );
                break;

            case 'boolean':
                $elVar->setAttribute( 'type', $valueType );
                $elVar->setAttribute( 'value', $value ? 'true' : 'false' );
                break;

            case 'NULL':
                $elVar->setAttribute( 'type', $valueType );
                $elVar->setAttribute( 'value', 'NULL' );
                break;

            case 'array':
                $elVar->setAttribute( 'type', $valueType );

                foreach ( $value as $iKey => $iVal )
                    self::transformVarToDomElement( $elVar, $iKey, $iVal, $initialIndent+1 );

                self::appendNewLine( $elVar );
                self::appendIndent( $elVar, $initialIndent+1 ); // space before </var>
                self::appendNewLine( $parent );
                break;

            default:
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::GENERIC_ERROR,
                    "Dumping values of type '$valueType' in XML is not supported" );
                break;
        }
    }

    /**
     * Generates DOM subtree from given schema array.
     *
     * @return DOMNode
     */
    private static final function transformArraySchemaToDom( $doc, $schema )
    {
        $elSchema = $doc->createElement( 'schema' );
        self::appendNewLine( $elSchema );

        // dump schema info
        $elInfo = $elSchema->appendChild( new DOMElement( 'info' ) );

        foreach ( $schema['_info'] as $param => $value )
            self::transformVarToDomElement( $elInfo, $param, $value );

        self::appendNewLine( $elSchema );

        // dump tables
        foreach ( $schema['tables'] as $tableName => $tableSchema )
        {
            $elTable = $elSchema->appendChild( $doc->createElement( 'table' ) );
            $elTable->setAttribute( 'name', $tableName );
            self::appendNewLine( $elTable );

            // dump table options (if specified)
            if ( isset( $tableSchema['options'] )  )
            {
                self::appendIndent( $elTable, 1 );
                $elTableOptions = $elTable->appendChild( new DOMElement( 'options' ) );

                foreach ( $tableSchema['options'] as $optKey => $optVal )
                    self::transformVarToDomElement( $elTableOptions, $optKey, $optVal, 1 );

                self::appendNewLine( $elTableOptions );
                self::appendIndent( $elTableOptions, 1 );
                self::appendNewLine( $elTable );
            }

            // dump fields
            foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
            {
                self::appendIndent( $elTable, 1 );
                $elField = $elTable->appendChild( $doc->createElement( 'field' ) );
                self::appendNewLine( $elTable );

                // supported props: type, length, not_null, default
                foreach ( $fieldSchema as $propName => $propVal )
                {
                    if ( $propName == 'default' )
                    {
                        if ( $propVal === false )
                            continue;
                        elseif ( $propVal === null )
                        {
                            $elField->setAttribute( 'default_null', '' );
                            continue;
                        }
                    }

                    // If a field property value is non-scalar we dump it in a special way.
                    if ( !is_numeric ( $propVal ) && !is_string( $propVal ) )
                        self::transformVarToDomElement( $elField, $propName, $propVal, 1 );
                    else
                        $elField->setAttribute( $propName, $propVal );
                }

                $elField->setAttribute( 'name', $fieldName );
            }

            // dump indexes
            foreach ( $tableSchema['indexes'] as $idxName => $idxSchema )
            {
                self::appendIndent( $elTable, 1 );
                $elIndex = $elTable->appendChild( $doc->createElement( 'index' ) );
                self::appendNewLine( $elTable );

                $elIndex->setAttribute( 'name', $idxName );
                $elIndex->setAttribute( 'type', $idxSchema['type'] );
                self::appendNewLine( $elIndex );

                // dump index fields
                foreach ( $idxSchema['fields'] as $idxField )
                {
                    self::appendIndent( $elIndex, 2 );

                    $elIdxField = $elIndex->appendChild( $doc->createElement( 'field' ) );
                    $elIdxField->setAttribute( 'name', $idxField );

                    self::appendNewLine( $elIndex );
                }

                // dump index options (if specified)
                if ( isset( $idxSchema['options'] )  )
                {
                    self::appendIndent( $elIndex, 2 );
                    $elIndexOptions = $elIndex->appendChild( new DOMElement( 'options' ) );

                    foreach ( $idxSchema['options'] as $optKey => $optVal )
                        self::transformVarToDomElement( $elIndexOptions, $optKey, $optVal, 2 );

                    self::appendIndent( $elIndexOptions, 2 );
                    self::appendNewLine( $elIndex );
                }

                self::appendIndent( $elIndex, 1 );
            }

            self::appendNewLine( $elSchema );
        }

        // dump sequences
        if ( isset( $schema['sequences'] ) )
        {
            self::appendNewLine( $elSchema );

            foreach ( $schema['sequences'] as $seqName => $seqSchema )
            {
                $elSeq = $elSchema->appendChild( new DOMElement( 'sequence' ) );
                $elSeq->setAttribute( 'name', $seqName );
                self::appendNewLine( $elSchema );

                if ( count( $seqSchema ) > 0 )
                {
                    foreach ( $seqSchema as $optKey => $optVal )
                        self::transformVarToDomElement( $elSeq, $optKey, $optVal, 1 );

                    self::appendNewLine( $elSeq );
                }
            }

            self::appendNewLine( $elSchema );
        }


        return $elSchema;
    }

    /**
     * Generates DOM subtree from given data array.
     *
     * @return DOMNode
     */
    private static final function transformArrayDataToDom( $doc, $data )
    {
        $elData = $doc->createElement( 'data' );
        self::appendNewLine( $elData );

        foreach ( $data as $tableName => $tableData )
        {
            $elTable = $elData->appendChild( new DOMElement( 'table' ) );
            $elTable->setAttribute( 'name', $tableName );
            self::appendNewLine( $elTable );


            /*
             * Process table fields.
             */
            self::appendIndent( $elTable, 1 );
            $elFields = $elTable->appendChild( new DOMElement( 'fields' ) );
            self::appendNewLine( $elFields );

            foreach ( $tableData['fields'] as $fieldName )
            {
                self::appendIndent( $elFields, 2 );
                $elField = $elFields->appendChild( new DOMElement( 'field' ) );
                self::appendNewLine( $elFields );

                $elField->setAttribute( 'name', $fieldName );
            }

            self::appendIndent( $elFields, 1 ); // indent before </fields>
            self::appendNewLine( $elTable ); // newline after </fields>

            /*
             * Process table data rows.
             */

            self::appendIndent( $elTable, 1 );
            $elRows = $elTable->appendChild( new DOMElement( 'rows' ) );
            self::appendNewLine( $elRows );

            foreach ( $tableData['rows'] as $row )
            {
                self::appendIndent( $elRows, 2 ); // indent before <row>
                $elRow = $elRows->appendChild( new DOMElement( 'row' ) );
                self::appendNewLine( $elRow ); // newline after <row>

                foreach ( $row as $value )
                {
                    self::appendIndent( $elRow, 3 );
                    if ( $value === null )
                        $elValue = new DOMElement( 'value_null' );
                    elseif ( is_string( $value ) )
                    {
                        // FIXME: implement fair charsets handling
                        $elValue = new DOMElement( 'value', self::xmlencode( $value ) );
                    }
                    else
                        $elValue = new DOMElement( 'value', self::xmlencode( $value ) );
                        //$elValue = new DOMElement( 'value', $value );

                    $elRow->appendChild( $elValue );
                    self::appendNewLine( $elRow );
                }

                self::appendIndent( $elRow, 2 ); // indent before </row>
                self::appendNewLine( $elRows ); // newline after </row>
            }

            self::appendIndent( $elRows, 1 ); // indent before </rows>
            self::appendNewLine( $elTable ); // newline after </rows>

            self::appendNewLine( $elData ); // newline after </table>
        }

        self::appendNewline( $elData );
        return $elData;
    }

    /**
     * Converts db schema/data from DOM tree to array.
     */
    private static final function transformDomToArray( $dom, $processSchema, $processData )
    {
        $schema = null;
        $data = null;

        $elRoot = $dom->documentElement;

        $items = $elRoot->childNodes;
        for ( $i = 0; $i < $items->length; $i++ )
        {
            $child = $items->item( $i );

            if ( get_class( $child ) != 'DOMElement' )
                continue;

            if ( $child->tagName == 'schema' && $processSchema )
                $schema = self::transformDomSchemaToArray( $child );
            elseif ( $child->tagName == 'data' && $processData )
                $data = self::transformDomDataToArray( $child );
        }

        $result = array();
        if ( isset( $schema ) )
            $result['schema'] = $schema;
        if ( isset( $data ) )
            $result['data'] = $data;

        return $result;
    }

    /**
     * Transforms a DOM element to a [non]scalar PHP value.
     *
     * If the element contains sub-elements it is transformed to PHP array.
     * Otherwise the element is transformed to the corresponding PHP scalar type.
     *
     * @throws ezcDbSchemaException::GENERIC_ERROR in case of parse error.
     * @return mixed The transformation result.
     */
    private static final function transformDomElementToVar( $el )
    {
        $value     = $el->getAttribute( 'value' );
        $valueType = $el->getAttribute( 'type' );
        $name      = $el->getAttribute( 'name' );

        switch ( $valueType )
        {
            case 'integer':
            case 'double':
            case 'string':
                eval( "\$castedValue = ($valueType)\$value;" );
                return $castedValue;

            case 'boolean':
                return ( $value == 'true' );

            case 'NULL':
                return null;

            case 'array':
                $arrayElements = $el->childNodes;

                $arrayValues = array();
                for ( $i = 0; $i < $arrayElements->length; $i++ )
                {
                    // skip text elements (if any)
                    if ( get_class( ( $child = $arrayElements->item( $i ) ) ) != 'DOMElement' )
                        continue;

                    $childName = $child->getAttribute( 'name' );
                    $index = is_numeric( $childName ) ? (int)$childName : $childName;
                    $arrayValues[$index] = self::transformDomElementToVar( $child );
                }

                return $arrayValues;

            default:
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::GENERIC_ERROR,
                    "Parsing values of type '$valueType' from XML is not supported" );
                break;
        }
    }


    /**
     * Transform a list of arbitrary elements from DOM to array.
     *
     * Transforms an element like in example given below to a PHP array.
     *
     * Example:
     * <code>
     *   <options>
     *     <var name="opt1" type="string" value="val1"/>
     *     <var name="opt2" type="integer" value="2"/>
     *   </opptions>
     * </code>
     *
     * @param   DOMElement $el DOM element which contents to transform to array.
     * @return array      The resulting array.
     */
    private static final function transformDomElementArrayToVar( $el )
    {
        $childNodes = $el->childNodes;

        $result = array();
        for ( $i = 0; $i < $childNodes->length; $i++ )
        {
            // skip text elements (if any)
            if ( get_class( ( $child = $childNodes->item( $i ) ) ) != 'DOMElement' )
                continue;

            $varName = $child->getAttribute( 'name' );
            $result[$varName] = self::transformDomElementToVar( $child );
        }

        return $result;
    }

    /**
     * Converts db schema from DOM tree to array.
     */
    private static final function transformDomSchemaToArray( $elSchema )
    {
        $schema = array();
        $tables = $elSchema->childNodes;

        // parse schema info
        $elInfo = $elSchema->getElementsByTagName( 'info' )->item( 0 );
        if ( $elInfo !== null )
        {
            $schema['_info'] = self::transformDomElementArrayToVar( $elInfo );
            $elSchema->removeChild( $elInfo );
        }

        // parse tables
        for ( $i = 0; $i < $tables->length; $i++ )
        {
            // skip text elements (if any)
            if ( get_class( ( $child = $tables->item( $i ) ) ) != 'DOMElement' )
                continue;

            switch ( $child->tagName )
            {
                case 'table':
                    list( $tableName, $tableSchema ) = self::parseTableXML( $child );
                    $schema['tables'][$tableName] = $tableSchema;
                    break;

                case 'sequence':
                    list( $sequenceName, $sequenceSchema ) = self::parseSequenceXML( $child );
                    $schema['sequences'][$sequenceName] = $sequenceSchema;
                    break;

                default:
                    throw new ezcDbSchemaException(
                        ezcDbSchemaException::GENERIC_ERROR,
                        "Unknown schema object (" . $child->tagName .
                        "). Table or sequence expected." );
                    break;
            }
        }

        return $schema;
    }

    /**
     * Converts db data from DOM tree to array.
     */
    private static final function transformDomDataToArray( $elData )
    {
        $data = array();
        $tables = $elData->childNodes;

        // parse tables
        for ( $i = 0; $i < $tables->length; $i++ )
        {
            // skip text elements (if any)
            if ( get_class( ( $child = $tables->item( $i ) ) ) != 'DOMElement' )
                continue;

            if ( $child->tagName != 'table' )
            {
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::GENERIC_ERROR,
                    "Unknown schema object (" . $chhild->tagName .
                    "). Table expected." );

            }

            $elTable = $child;
            $tableName = $child->getAttribute( 'name' );
            $tableData = array( 'fields' => array(), 'rows' => array() );
            $tableObjects = $elTable->childNodes;

            for ( $j = 0; $j < $tableObjects->length; $j++ )
            {
                // skip text elements (if any)
                if ( get_class( ( $tableObject = $tableObjects->item( $j ) ) ) != 'DOMElement' )
                    continue;

                switch ( $tableObject->tagName )
                {
                    case 'fields':
                        $fields = $tableObject->childNodes;
                        for ( $k = 0; $k < $fields->length; $k++ )
                        {
                            $field = $fields->item( $k );
                            if ( $field->nodeType  != XML_ELEMENT_NODE )
                                continue;
                            $tableData['fields'][] = $field->getAttribute( 'name' );
                        }

                        continue;

                    case 'rows':
                        // process rows
                        $rows = $tableObject->childNodes;
                        $rowArray = array();
                        for ( $k = 0; $k < $rows->length; $k++ )
                        {
                            $row = $rows->item( $k );
                            if ( $row->nodeType  != XML_ELEMENT_NODE )
                                continue;

                            // process values
                            $values = $row->childNodes;
                            $valuesArray = array();
                            for ( $l = 0; $l < $values->length; $l++ )
                            {
                                $elValue = $values->item( $l );
                                if ( $elValue->nodeType  != XML_ELEMENT_NODE )
                                    continue;

                                if ( $elValue->tagName == 'value_null' )
                                    $val = null;
                                else // <value>
                                    $val = $elValue->textContent;

                                $valuesArray[] = $val;
                            }

                            $rowArray[] = $valuesArray;
                        }

                        $tableData['rows'] = $rowArray;

                        break;

                    default:
                        throw new ezcDbSchemaException(
                            ezcDbSchemaException::GENERIC_ERROR,
                            "Unknown table info tag (" . $tableObject->tagName .
                            "). Either 'rows' or 'fields' is expected." );
                }
            }



            $data[$tableName] = $tableData;
        }

        return $data;
    }


    /**
     * Parse table schema from XML
     *
     * @return array An array of two elements: table name and table schema.
     */
    private static final function parseTableXML( $elTable )
    {
        $tableName = $elTable->getAttribute( 'name' );
        $tableSchema = array();
        $tableSchema['name'] = $tableName;

        // parse fields and indexes
        $tableChildren = $elTable->childNodes;
        for ( $j = 0; $j < $tableChildren->length; $j++ )
        {
            // skip text elements (if any)
            if ( get_class( ( $tableChild = $tableChildren->item( $j ) ) ) != 'DOMElement' )
                continue;

            switch ( $tableChild->tagName )
            {
                case 'field':
                    // parse field
                    list( $fieldName, $fieldSchema ) = self::parseFieldXML( $tableChild );
                    $tableSchema['fields'][$fieldName] = $fieldSchema;
                    break;

                case 'index':
                    // parse index
                    list( $indexName, $indexSchema ) = self::parseIndexXML( $tableChild );
                    $tableSchema['indexes'][$indexName] = $indexSchema;
                    break;

                case 'options':
                    $tableSchema['options'] = self::transformDomElementArrayToVar( $tableChild );
                    break;

                default:
                    throw new ezcDbSchemaException(
                        ezcDbSchemaException::GENERIC_ERROR,
                        "Unknown table object (" . $tableChild->tagName .
                        "). Field or index expected." );

            }
        }

        if ( !isset( $tableSchema['indexes'] ) )
            $tableSchema['indexes'] = array();

        return array( $tableName, $tableSchema );
    }

    /**
     * Parse field schema from XML
     *
     * @return array An array of two elements: field name and field schema.
     */
    private static final function parseFieldXML( $elField )
    {
        $fieldSchema = array();
        $attributes = $elField->attributes;
        $defaultNull = false;

        for ( $i=0; $i < $attributes->length; $i++ )
        {
            $attr = $attributes->item( $i );

            switch ( $attr->name )
            {
                case 'default_null':
                    $defaultNull = true;
                case 'name':
                    break;
                case 'length':
                    $fieldSchema[$attr->name] = (int) $attr->value;
                    break;
                default:
                    $fieldSchema[$attr->name]  = $attr->value;
            }
        }

        if ( isset( $fieldSchema['default'] ) )
        {
            if ( in_array( $fieldSchema['type'],
                           array( 'int', 'float', 'auto_increment' ) ) )
            {
                $fieldSchema['default'] = (int) $fieldSchema['default'];
            }
        }
        else // default value is not set
        {
            if ( $defaultNull )
                $fieldSchema['default'] = null;
            else
                $fieldSchema['default'] = false;
        }

        // Parse attributes defined as sub-elements in the DOM tree
        // (usually this means that they have non-scalar values).
        if ( count( $elField->childNodes ) )
        {
            $complexAttrs = self::transformDomElementArrayToVar( $elField );
            foreach ( $complexAttrs as $attrName => $attrVal )
                $fieldSchema[$attrName] = $attrVal;
        }

        $result = array( $elField->getAttribute( 'name' ), $fieldSchema );
        return $result;
    }

    /**
     * Parse index schema from XML
     *
     * @return array An array of two elements: index name and index schema.
     */
    private static final function parseIndexXML( $elIndex )
    {
        $idxSchema = array();


        $idxType = $elIndex->getAttribute( 'type' );
        $idxSchema['type'] = $idxType;

        // parse index options
        $elIdxOptions = $elIndex->getElementsByTagName( 'options' )->item( 0 );
        if ( $elIdxOptions !== null )
        {
            $idxSchema['options'] = self::transformDomElementArrayToVar( $elIdxOptions );
            $elIndex->removeChild( $elIdxOptions );
        }

        // process index fields
        $idxChildren = $elIndex->childNodes;
        $idxFieldsSchema = array();
        for ( $i=0; $i < $idxChildren->length; $i++ )
        {
            if ( get_class( ( $elField = $idxChildren->item( $i ) ) ) != 'DOMElement' )
                continue;

            if ( $elField->tagName != 'field' )
            {
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::GENERIC_ERROR,
                    "Unknown index element (" . $elField->tagName .
                    "). Field expected." );

            }

            $idxFieldsSchema[] = $elField->getAttribute( 'name' );
        }

        $idxSchema['fields'] = $idxFieldsSchema;

        ksort( $idxSchema );

        $result = array( $elIndex->getAttribute( 'name' ), $idxSchema );
        return $result;
    }

    /**
     * Parse sequence schema from XML
     *
     * @return array An array of two elements: sequence name and sequence schema.
     */
    private static final function parseSequenceXML( $elSequence )
    {
        $seqName = $elSequence->getAttribute( 'name' );
        $seqSchema = self::transformDomElementArrayToVar( $elSequence );

        return array( $seqName, $seqSchema );
    }

    /**
     * Append newline to the given element.
     *
     * Used to generate eye-friendly XML.
     */
    private static final function appendNewline( $element )
    {
        $element->appendChild( new DOMText( "\n" ) );
    }

    /**
     * Append indeentation to the given element.
     *
     * Used to generate eye-friendly XML.
     */
    private static final function appendIndent( $element, $nestingLevel )
    {
        $elIndent = new DOMText( str_repeat( '  ', $nestingLevel ) );
        $element->appendChild( $elIndent );
    }

    /**
     * Escapes non-latin characters with numeric HTML entities.
     *
     * @return string  escaped string.
     */
    private static final function xmlencode( $string )
    {
        return strtr( $string, self::$XmlCharTransTable );
    }


    /**
     * Replaces numeric HTML entitied with corresponding characters.
     *
     * @return string  unescaped string.
     */
    private static final function xmldecode( $string )
    {
        return strtr( $string, self::$XmlCharTransTableReverse );
    }

    /**
     * Actually transfer data [source].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function transfer( $storage, $storageType, $dstHandler )
    {
        $file = $storage;

        $reader = new XMLReader();
        $reader->open( $file );

        $row = null;
        $fields = null;
        $tableName = null;

        while ( $reader->read() )
        {
            if ( $reader->nodeType == XMLREADER::ELEMENT )
            {
                switch ( $reader->name )
                {
                    case 'value':
                        $reader->read(); // read #text element
                        $row[] = $reader->value;
                        break;
                    case 'value_null':
                        $row[] = null;
                        break;
                    case 'row':
                        $row = array();
                        break;
                    case 'field':
                        $fields[] = $reader->getAttribute( 'name' );
                        break;
                    case 'fields':
                        $fields = array();
                        break;
                    case 'table':
                        $tableName = $reader->getAttribute( 'name' );
                        break;

                }
            }

            elseif ( $reader->nodeType == XMLREADER::END_ELEMENT )
            {
                switch ( $reader->name )
                {
                    case 'row':
                        $dstHandler->saveRow( $row );
                        break;
                    case 'fields':
                        $dstHandler->setTableBeingTransferred( $tableName, $fields );
                        $fields = null;
                        break;
                    case 'table':
                        $tableName = null;
                        break;
                }
            }
        }
    }

    /**
     * Prepare destination handler for transfer [destination].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function openTransferDestination( $storage, $storageType )
    {
        $this->storeFileHandler = self::fopen( $storage, 'w' );
        $this->currentTableBeingStored = null;
        $file = $this->storeFileHandler;

        $string =
            "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n" .
            "<ezcDatabaseSchema>\n" .
            "<data>\n";
        fputs( $file, $string );
    }

    /**
     * Tell destination handler that there is no more data to transfer. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function closeTransferDestination()
    {
        $file = $this->storeFileHandler;
        fputs( $file, "  </rows>\n</table>\n</data>\n</ezcDatabaseSchema>" );
        fclose( $file );

        $this->storeFileHandler = null;
        $this->currentTableBeingStored = null;
    }

    /**
     * Start to transfer data of the next table. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function setTableBeingTransferred( $tableName, $tableFields = null )
    {
        $file = $this->storeFileHandler;

        if ( isset( $this->currentTableBeingStored ) )
            fputs( $file, "</rows>\n</table>\n" );

        fputs( $file, "<table name=\"$tableName\">\n" );

        if ( isset( $tableFields ) )
        {
            $fieldsTags = '';
            foreach ( $tableFields as $field )
                $fieldsTags .= "    <field name=\"$field\" />\n";

            fputs( $file,
                   "  <fields>\n" .
                   $fieldsTags .
                   "  </fields>\n" );
        }

        fputs( $file, "  <rows>\n" );

        $this->currentTableBeingStored = $tableName;
    }

    /**
     * Save given row. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function saveRow( $row )
    {
        $file = $this->storeFileHandler;
        $string = "    <row>\n";

        foreach ( $row as $value )
        {
            if ( $value === null )
                $string .= "      <value_null/>\n";
            else
            {
                $string .=
                    '      <value>' .
                    htmlspecialchars( $value, ENT_QUOTES ) .
                    "</value>\n";
            }
        }

        $string .= "    </row>\n";
        fputs( $file, $string );
    }
}

?>
