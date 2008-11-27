<?php
/**
 * File containing the ezcWebdavLockCheckPropertyCollector class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Collects properties found during lock checking.
 *
 * This lock check observer class collects the properties found (status 200)
 * during lock violation checks.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockCheckPropertyCollector implements ezcWebdavLockCheckObserver
{
    /**
     * Collected properties.
     *
     * Properties collected.
     *
     * Structure:
     *
     * <code>
     * <?php
     *  array(
     *      '<path>' => ezcWebdavBasicPropertyStorage(),
     *      '<otherpath>' => ezcWebdavBasicPropertyStorage(),
     *      // ...
     *  );
     * ?>
     * </code>
     * 
     * @var array(string=> ezcWebdavBasicPropertyStorare)
     */
    protected $properties = array();

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
        $path = $response->node->path;
        
        foreach ( $response->responses as $propStatResponse )
        {
            if ( $propStatResponse->status === ezcWebdavResponse::STATUS_200 )
            {
                $this->properties[$path] = $propStatResponse->storage;
            }
        }
    }

    /**
     * Returns collected properties for $path.
     * 
     * @param string $path 
     * @return ezcWebdavBasicPropertyStorage
     */
    public function getProperties( $path )
    {
        if ( isset( $this->properties[$path] ) )
        {
            return $this->properties[$path];
        }
        return new ezcWebdavBasicPropertyStorage();
    }
}

?>
