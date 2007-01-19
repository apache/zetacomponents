<?php
class testDelayedInitTemplateConfiguration
{
    static function configureObject( $object )
    {
        $object->context = new ezcTemplateNoContext;
    }
}
?>
