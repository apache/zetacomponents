<?php
/**
 * File containing the ezcWebdavLockPathCollector class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Collects paths found during lock checking.
 *
 * This lock check observer class collects the paths found during lock
 * violation checks.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockCheckPathCollector implements ezcWebdavLockCheckObserver
{
    /**
     * Collected paths.
     *
     * @var array(string)
     */
    protected $paths = array();

    /**
     * Collects properties from the given $response.
     *
     * This method collects the found (status 200) properties from the given
     * propfind response. Properties for a certain path can be accessed
     * afterwards through {@link getProperties()}.
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response )
    {
        $this->paths[] = $response->node->path;
    }

    /**
     * Returns collected properties for $path.
     * 
     * @param string $path 
     * @return ezcWebdavBasicPropertyStorare
     */
    public function getPaths()
    {
        return $this->paths();
    }
}

?>
