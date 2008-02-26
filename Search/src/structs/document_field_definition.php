<?php
class ezcSearchDefinitionDocumentField
{
    public $type;
    public $field;
    public $boost;
    public $inResult;

    public function __construct( $field, $type, $boost, $inResult = true )
    {
        $this->field = $field;
        $this->type = $type;
        $this->boost = $boost;
        $this->inResult = $inResult;
    }

}
?>
