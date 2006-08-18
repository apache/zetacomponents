<?php

class ezcTemplateCustomBlockDefinition extends ezcBaseStruct
{
    public $class;
    public $method;
    public $isNestingBlock;

    public $hasStartExpression;
    public $optionalParameters = array();
    public $requiredParameters = array();
}
?>
