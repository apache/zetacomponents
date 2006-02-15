<?php
if ( ezcInputForm::hasGetData() )
{
    $form = new ezcInputForm( INPUT_GET, $definition );

    foreach ( $definition as $name => $dummy )
    {
        $propertyName = "property_$name";
        $propertyWarningName = "warning_$name";
        if ( $form->hasValidData( $name ) )
        {
            $$propertyName = $form->$name;
        }
        else
        {
            $$propertyName =
                htmlspecialchars( $form->getUnsafeRawData( $name ) );
            $$propertyWarningName = '[invalid]';
        }
    }
}
?>
