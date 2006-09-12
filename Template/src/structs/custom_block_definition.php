<?php

class ezcTemplateCustomBlockDefinition extends ezcTemplateCustomExtension
{
    public $class;
    public $method;

    public $hasCloseTag;

    public $startExpressionName;
    public $optionalParameters = array();
    public $requiredParameters = array();
}
?>
