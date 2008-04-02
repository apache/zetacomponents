<?php
class ezcSearchDocumentDefinition
{
    const STRING = 1;
    const TEXT = 2;
    const HTML = 3;
    const DATE = 4;

    public $documentType;
    public $idProperty = null;
    public $fields = array();

    public function __construct( $documentType )
    {
        $this->documentType = $documentType;
    }

    public function getFieldNames()
    {
        return array_keys( $this->fields );
    }

    public function getSelectFieldNames()
    {
        $fields = array();
        foreach ( $this->fields as $name => $def )
        {
            if ( $def->inResult )
            {
                $fields[] = $name;
            }
        }
        return $fields;
    }

    public function getHighlightFieldNames()
    {
        $fields = array();
        foreach ( $this->fields as $name => $def )
        {
            if ( $def->highlight )
            {
                $fields[] = $name;
            }
        }
        return $fields;
    }
}
?>
