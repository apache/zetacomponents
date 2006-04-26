<?php

/**
 * @access private
*/
class ezcTemplateType
{
    /**
     * This method couldn't be translated directly because the parameter
     * of empty should always be a variable. 
     *
     * This wrapper function makes it possible to call: is_empty("");
     */
    public static function is_empty( $var )
    {
        return empty( $var );
    }
}


?>
