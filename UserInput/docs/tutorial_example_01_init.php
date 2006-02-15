<?php
foreach ( $definition as $name => $dummy )
{
    $propertyName = "property_$name";
    $propertyWarningName = "warning_$name";
    $$propertyName = '';
    $$propertyWarningName = '';
}
?>
