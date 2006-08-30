<?php
ezcTestRunner::addFileToFilter( __FILE__ );

class TestBlocks implements ezcTemplateCustomBlock, ezcTemplateCustomFunction
{
    public static function getCustomFunctionDefinition( $name )
    {
        switch( $name )
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
        }
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
  
    public static function getCustomBlockDefinition( $name )
    {
        switch( $name )
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
        }
    }


	public static function reflectParameters( $parameters, $source = null )
	{
		return print_r( $parameters, true );
	}
}


?>
