<?php

require_once 'Base/src/base.php';

/**
 * Autoload ezc classes 
 * 
 * @param string $className 
 */
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

// Analyzation of the MIME type is done during creation.
$image = new ezcImageAnalyzer( dirname( __FILE__ ).'/toby.jpg' );

if ( $image->mime == 'image/tiff' || $image->mime == 'image/jpeg' )
{
     // Analyzation of further image data is done during access of the data
     echo 'Photo taken on '.date( 'Y/m/d, H:i', $image->data->date ).".\n";
}
elseif ( $mime !== false )
{
     echo "Format was detected as {$mime}.\n";
}
else
{
     echo "Unknown photo format.\n";
}

?>
