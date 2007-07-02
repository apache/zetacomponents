<?php
class Sha1CustomBlock implements ezcTemplateCustomFunction
{
    public static function getCustomFunctionDefinition($name)
    {
        switch ($name)
        {
            case "str_sha1":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = false;
                $def->method = "sha1";
                $def->parameters[] = "text";
                return $def;
        }
    }

}



?>
