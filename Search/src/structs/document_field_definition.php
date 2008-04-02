<?php
class ezcSearchDefinitionDocumentField
{
    public $type;
    public $field;
    public $boost;
    public $inResult;
    public $highlight;

    public function __construct( $field, $type = ezcSearchDocumentDefinition::TEXT, $boost = 1, $inResult = true, $multi = false, $highlight = false )
    {
        $this->field = $field;
        $this->type = $type;
        $this->boost = $boost;
        $this->inResult = $inResult;
        $this->multi = $multi;
        $this->highlight = $highlight;
    }

}
?>
