<?php
class ezcSearchDefinitionDocumentField
{
    public $type;
    public $field;
    public $boost;

    public function __construct( $field, $type, $boost )
    {
        $this->field = $field;
        $this->type = $type;
        $this->boost = $boost;
    }

}
?>
