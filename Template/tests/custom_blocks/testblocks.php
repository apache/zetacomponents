<?php
class TestBlocks implements ezcTemplateCustomBlock, ezcTemplateCustomFunction
{
    public static function getCustomFunctionDefinition( $name )
    {
        switch ( $name )
        {
            case "no_parameters": 
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "noParameters";
                $def->parameters = array();
                return $def;

            case "req_parameter": 
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "requiredParameter";
                $def->parameters = array( "required" );
                return $def;

            case "opt_parameter": 
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "optionalParameter";
                $def->parameters = array( "[optional]" );
                return $def;


            case "named_parameters":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParameters";
                $def->parameters = array( "p1", "[p2]", "[p3]");
                return $def;

            case "named_parameters_reflection":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParameters";
                $def->parameters = array( "p1", "[p2]", "[p3]");
                return $def;


            case "named_parameters_invalid_def":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParameters";
                $def->parameters = array( "[p1]", "[p2]", "[p3]");
                return $def;

            case "named_parameters_invalid_def2":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParameters";
                $def->parameters = array( "p1", "[p2]", "[p3]", "[p4]");
                return $def;
 
            case "named_parameters_invalid_def3":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParameters";
                $def->parameters = array( "p1", "[p2]", "p3");
                return $def;

            case "named_parameters_obj":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "namedParametersObj";
                return $def;


            case "template_parameter":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "templateParameter";
                $def->parameters = array( "p1", "[p2]");
                $def->sendTemplateObject = true;
                return $def;

            case "template_parameter_reflection":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "templateParameter";
                $def->sendTemplateObject = true;
                return $def;


            case "variable_argument_list":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "varArgList";
                $def->variableArgumentList = true;
                return $def;

        }
    }

    public static function wrongBlock()
    {
        echo "wrongbLock";
        exit();
    }

    public static function noParameters()
    {
        return "NoParameter";
    }

    public static function requiredParameter( $req )
    {
		return print_r( $req, true );
    }

    public static function optionalParameter( $opt = "default" )
    {
		return print_r( $opt, true );
    }

    public static function namedParameters($p1, $p2 = "p2", $p3 = "p3")
    {
        return $p1." ".$p2." ".$p3;
    }
  
    public static function namedParametersObj($p1, $p2 = "p2", $p3 = array(), $p4 = null, $p5 = 5)
    {
        return var_export($p1, true)." ".var_export($p2, true)." ".var_export($p3, true) ." ".var_export($p4, true)." ".var_export($p5, true);
    }
 
    public static function templateParameter( $template, $p1, $p2 = "p2")
    {
        return get_class( $template ) . ' ' . get_class( $template->usedConfiguration ) . " $p1 $p2";
    }

    public static function varArgList($a, $b=2)
    {
        return var_export(func_get_args(), true);
    }
 
    public static function getCustomBlockDefinition( $name )
    {
        switch ( $name )
        {
            case "nesting_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "";
                $def->requiredParameters = array();
                $def->optionalParameters = array("optional");
                return $def;

            case "nesting_req_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array();
                return $def;

            case "nesting_req_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array("optional");
                return $def;

            case "nesting_req_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array("start_expression");
                $def->optionalParameters = array();
                return $def;

            case "nesting_opt_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array();
                $def->optionalParameters = array("start_expression");
                return $def;

            case "nesting_incorrect_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = true;
                $def->startExpressionName = "start_expresssion";
                $def->requiredParameters = array();
                $def->optionalParameters = array("bla");
                return $def;


////////////////////////////

            case "inline_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array();
                $def->optionalParameters = array("optional");
                return $def;

            case "inline_req_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array();
                return $def;

            case "inline_req_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array("optional");
                return $def;

            case "inline_req_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array("start_expression");
                $def->optionalParameters = array();
                return $def;

            case "inline_opt_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array();
                $def->optionalParameters = array("start_expression");
                return $def;

            case "inline_incorrect_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expresssion";
                $def->requiredParameters = array();
                $def->optionalParameters = array("bla");
                return $def;

            case "variable_parameters": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->requiredParameters = array("required");
                $def->optionalParameters = array();
                $def->excessParameters = true;
                return $def;


////////////////////////////

            case "static_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array();
                $def->optionalParameters = array("optional");
                $def->isStatic = true;
                return $def;

            case "static_req_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array();
                $def->isStatic = true;
                return $def;

            case "static_req_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array("optional");
                $def->isStatic = true;
                return $def;

            case "static_req_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array("start_expression");
                $def->optionalParameters = array();
                $def->isStatic = true;
                return $def;

            case "static_opt_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expression";
                $def->requiredParameters = array();
                $def->optionalParameters = array("start_expression");
                $def->isStatic = true;
                return $def;

            case "static_incorrect_startexpression": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "start_expresssion";
                $def->requiredParameters = array();
                $def->optionalParameters = array("bla");
                $def->isStatic = true;
                return $def;


            case "static_req_opt_parameter": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "reflectParameters";
                $def->hasCloseTag = false;
                $def->startExpressionName = "";
                $def->requiredParameters = array("required");
                $def->optionalParameters = array("optional");
                $def->isStatic = true;
                return $def;


            case "set_block":
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "setBlock";
                $def->hasCloseTag = true;
                $def->requiredParameters = array("variable");
                return $def;


           case "template_object_no_close":
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "templateObject";
                $def->hasCloseTag = false;
                $def->requiredParameters = array("required");
                $def->sendTemplateObject = true;
                return $def;


           case "template_object_close":
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "templateObject";
                $def->hasCloseTag = true;
                $def->requiredParameters = array("required");
                $def->sendTemplateObject = true;
                return $def;

        }
    }


	public static function reflectParameters( $parameters, $source = null )
	{
		return print_r( $parameters, true );
	}

    public static function setBlock( $parameters, $source)
    {
        var_dump($parameters);
        var_dump($source);
            
    }

    public static function templateObject( $template, $parameters, $source = null)
    {
        $out = get_class($template->usedConfiguration) . "\n";
        $out .= print_r( $parameters, true ) . "\n";
        $out .= $source;
        return $out;
    }
}


?>
