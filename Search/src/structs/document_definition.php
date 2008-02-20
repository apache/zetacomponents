<?php
class ezcSearchDocumentDefinition
{
    const STRING = 1;
    const TEXT = 2;
    const HTML = 3;
    const DATE = 4;

    public $idProperty = null;
    public $fields = array();

    public function getFieldNames()
    {
        return array_keys( $this->fields );
    }
}
?>
