<?php
class testDelayedInitTemplateConfiguration implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->context = new ezcTemplateNoContext;
    }
}
?>
