<?php
class cblockTemplateExtension implements ezcTemplateCustomBlock
{
    public static function getCustomBlockDefinition( $name )
    {
        switch ( $name )
        {
            case 'cblock':
            {
                $def = new ezcTemplateCustomBlockDefinition();

                $def->class = __CLASS__;
                $def->method = "cblock";
                $def->hasCloseTag = true;
                $def->requiredParameters = array();

                return $def;
            } break;
        }

        return null;
    }

    public static function cblock( $parameters, $code )
    {
		return print_r( $code, true );
    }
}

?>
