<?php
/**
 * File containing the class representing collection structs
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Collection struct
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavCollection extends ezcBaseStruct
{
    /**
     * Path to ressource
     * 
     * @var string
     */
    public $path;

    /**
     * Array with childs of ressource
     * 
     * @var array
     */
    public $childs;

    /**
     * Live properties of ressource.
     * 
     * @var array
     */
    public $liveProperties;

    /**
     * Construct a collection structure from path, properties and contents of a
     * ressource.
     * 
     * @param string $path 
     * @param ezcWebdavPropertyStorage $liveProperties 
     * @param array $childs 
     * @return void
     */
    public function __construct( $path, ezcWebdavPropertyStorage $liveProperties = null, array $childs = array() )
    {
        $this->path = $path;
        $this->liveProperties = $liveProperties;
        $this->childs = $childs;
    }
}

?>
