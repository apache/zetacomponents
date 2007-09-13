<?php
/**
 * File containing the class representing resource structs
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Resource struct
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavResource extends ezcBaseStruct
{
    /**
     * Path to resource
     * 
     * @var string
     */
    public $path;

    /**
     * Resource contents
     * 
     * @var string
     */
    public $content;

    /**
     * Live properties of resource.
     * 
     * @var array
     */
    public $liveProperties;

    /**
     * Construct a resource structure from path, properties and contents of a
     * resource.
     * 
     * @param string $path 
     * @param ezcWebdavPropertyStorage $liveProperties 
     * @param string $content 
     * @return void
     */
    public function __construct( $path, ezcWebdavPropertyStorage $liveProperties, $content = null )
    {
        $this->path = $path;
        $this->liveProperties = $liveProperties;
        $this->content = $content;
    }
}

?>
