<?php

class ezcWebdavLockPropertyCollector implements ezcWebdavLockLockRequestGenerator
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
        $path = $response->node->getPath();
        
        foreach ( $response->responses as $propStatResponse )
        {
            if ( $propStatResponse->status === ezcWebdavRequest::STATUS_200 )
            {
                $this->properties[$path] = $propStatResponse->storage;
            }
        }
    }

    /**
     * Returns an empty array, since this generator only collects properties.
     * 
     * @return array
     */
    public function getRequests()
    {
        return array();
    }

    /**
     * Returns collected properties for $path.
     * 
     * @param string $path 
     * @return ezcWebdavBasicPropertyStorare
     */
    public function getProperties( $path )
    {
        if ( isset( $this->properties[$path] ) )
        {
            return $this->properties[$path];
        }
        return new ezcWebdavBasicPropertyStorare();
    }
}

?>
