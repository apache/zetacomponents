<?php

class ezcTemplateCustomBlockDefinition
{
    public $class;
    public $method;
    public $parameters = array();
    public $isNestingBlock;

    public $hasStartExpression;
    public $optionalParameters = array();
    public $requiredParameters = array();
}
