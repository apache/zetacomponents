<?php

require_once dirname( __FILE__ ) . "/../../../../Base/src/base.php";

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

$out = new ezcConsoleOutput();

$opts = new ezcConsoleQuestionDialogOptions();
$opts->text = "Please enter your email address: ";
$opts->validator = new ezcConsoleQuestionDialogRegexValidator(
    "/[a-z0-9_\.]+@[a-z0-9_\.]+\.[a-z0-9_\.]+/"
);

$dialog = new ezcConsoleQuestionDialog( $out, $opts );

echo "The email address is " . ezcConsoleDialogViewer::displayDialog( $dialog ) . ".\n";

?>
