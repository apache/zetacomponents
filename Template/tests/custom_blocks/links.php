<?php
class LinksCustomBlock implements ezcTemplateCustomFunction, ezcTemplateCustomBlock
{
    public static function getCustomFunctionDefinition($name)
    {
        switch ($name)
        {
            case "link_to":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "link_to";
                $def->parameters[] = "name";
                $def->parameters[] = "url";
                return $def;
        }
    }

    public static function getCustomBlockDefinition($name)
    {
        switch ($name)
        {
            case "link":
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "linkCustomBlock";
                $def->startExpressionName = "from";
                $def->requiredParameters = array("from", "to" );
                return $def;
        }
    }
   
    public static function link_to($name, $url)
    {
        return "<a href=\"".$url."\">".$name."</a>";
    }

    public static function linkCustomBlock( $parameters )
    {
        return self::link_to( $parameters["from"], $parameters["to"] );
    }
}



?>
