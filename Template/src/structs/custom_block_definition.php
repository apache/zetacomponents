<?php

class ezcTemplateCustomBlockDefinition extends ezcBaseStruct
{
    public $class;
    public $method;
    public $isNestingBlock;

    public $hasStartExpression;
    public $startExpressionName;
    public $optionalParameters = array();
    public $requiredParameters = array();
}
?>
