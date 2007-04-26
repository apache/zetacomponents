<?php
$dir = dirname( __FILE__ );
$dirParts = explode( '/', $dir );

if ( $dirParts[count( $dirParts ) - 1] === 'src' )
{
    require 'Base/src/base.php'; // svn, bundle
}
else if ( $dirParts[count( $dirParts ) - 2] === 'ezc' )
{
    require 'ezc/Base/base.php'; // pear
}
else
{
    die( "Your environment isn't properly set-up. Please refer to the eZ components documentation at http://components.ez.no/doc ." );
}

function __autoload( $className )
{
	ezcBase::autoload( $className );
}
?>
