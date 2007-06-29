<?php
/**
 * Include file that can be used for a quick setup of the eZ Components.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Base
 */
$dir = dirname( __FILE__ );
$dirParts = explode( DIRECTORY_SEPARATOR, $dir );

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

/**
 * Implements the __autoload mechanism for PHP - which can only be done once
 * per request.
 *
 * @param string $className  The name of the class that should be loaded.
 */
function __autoload( $className )
{
	ezcBase::autoload( $className );
}
?>
