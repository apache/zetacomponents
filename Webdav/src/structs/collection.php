<?php
/**
 * File containing the ezcWebdavCollection struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct representing collection resources.
 *
 * This struct is used to represent collection resources, in contrast to {@link
 * ezcWebdavResource}, which represents non-collection resources.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavCollection extends ezcBaseStruct
{
    /**
     * Path to resource.
     * 
     * @var string
     */
    public $path;

    /**
     * Array with children of resource.
     * 
     * @var array(int=>ezcWebdavCollection|ezcWebdavResource)
     *
     * @apichange This property will be renamed to $children in the next major
     *            release.
     */
    public $childs;

    /**
     * Live properties of resource.
     * 
     * @var ezcWebdavPropertyStorage
     */
    public $liveProperties;

    /**
     * Creates a new collection struct.
     *
     * A new collection struct is created, representing the collection
     * referenced by $path, with the given $liveProperties and $children
     * ($childs) elements.
     * 
     * @param string $path 
     * @param ezcWebdavPropertyStorage $liveProperties 
     * @param array $children
     * @return void
     */
    public function __construct( $path, ezcWebdavPropertyStorage $liveProperties = null, array $children = array() )
    {
        $this->path = $path;
        $this->liveProperties = $liveProperties;
        $this->childs = $children;
    }
}

?>
