<?php

require 'tutorial_autoload.php';

// Load custom directive
require 'address_directive.php';

$document = new ezcDocumentRst();
$document->registerDirective( 'address', 'myAddressDirective' );
$document->loadString( <<<EORST
Address example
===============

.. address:: John Doe
    :street: Some Lane 42
EORST
);

$docbook = $document->getAsDocbook();
echo $docbook->save();
?>
