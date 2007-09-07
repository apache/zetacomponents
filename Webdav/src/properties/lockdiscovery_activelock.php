<?php
/**
 * File containing the lockdiscovery property activelock class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Objects of this class are used in the ezcWebdavLockdiscoveryProperty class.
 *
 * @property int $depth
 *           Constant indicating 0, 1 or infinity.
 * @property string $owner
 *           Owner of this lock (free form string). Null if not provided.
 * @property DateTime|null $timeout
 *           Timeout date or null for inifinite. Null if not provided.
 * @property array(string) $tokens
 *           Tokens submitted in <locktocken> (URIs). Null if not provided.
 *           These are originally covered in additional <href> elements, which
 *           is left out here.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavLockdiscoveryPropertyActivelock extends ezcWebdavSupportedlockPropertyLockentry
{
    const DEPTH_ZERO      = 0;
    const DEPTH_ONE       = 1;
    const DEPTH_INFINITY  = -1;

    // To be implemented.
}


?>
