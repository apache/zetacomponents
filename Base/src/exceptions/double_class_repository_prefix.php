<?php
/**
 * File containing the ezcBaseDoubleClassRepositoryPrefix class
 *
 * @package Base
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcBaseDoubleClassRepositoryPrefix is thrown whenever you try to register a
 * class repository with a prefix that has already been added before.
 *
 * @package Base
 * @version //autogen//
 */
class ezcBaseDoubleClassRepositoryPrefix extends ezcBaseException
{
    /**
     * Constructs a new ezcBaseDoubleClassRepositoryPrefix for the $prefix that
     * points to $basePath with autoload directory $autoloadDirPath.
     */
    function __construct( $prefix, $basePath, $autoloadDirPath )
    {
        parent::__construct( "The class repository in '{$basePath}' (with autoload dir '{$autoloadDirPath}') can not be added because another class repository already uses the prefix '{$prefix}'." );
    }
}
?>
