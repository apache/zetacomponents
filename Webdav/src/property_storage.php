<?php
/**
 * File containing the ezcWebdavPropertyStorage class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to manage instances of ezcWebdavProperty.
 * An instance of this class is used to manage WebDAV properties, namely
 * instances of {@link ezcWebdavProperty}. Properties are structured by their
 * name and the namespace they belong to. 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPropertyStorage
{
    /**
     * Stores the properties.
     * The structure of this array is:
     * <code>
     * array(
     *     'DAV:' => array(
     *         '<live property name>' => ezcWebdavLiveProperty,
     *         // ...
     *     ),
     *     '<another namespace URI>'array(
     *         '<dead property name>' => ezcWebdavDeadProperty,
     *         // ...
     *     ),
     *     // ...
     * )
     * </code>
     * 
     * @var array
     */
    protected $properties = array();

    /**
     * Attaches a property to the storage.
     * Adds the given $property to the storage. The property can later be
     * accessed by its name in combination with the namespace. Live properties
     * (and only these) reside in the namespace DAV:, which is the default for
     * all accessor methods.
     *
     * If a property with the same namespace and name is already contained in
     * the storage, it will be overwritten.
     * 
     * @param ezcWebdavProperty $property 
     * @return void
     */
    public function attach( ezcWebdavProperty $property )
    {
        $this->properties[$property->namespace][$property->name] = $property;
    }
    
    /**
     * Detaches a property from the storage.
     * Removes the property with the given $name from the storage. If the
     * property did not exist in the storage, the call is silently ignored. If
     * no $namespace is given, the default namespace DAV: is used.
     * 
     * @param ezcWebdavProperty $property 
     * @return void
     */
    public function detach( $name, $namespace = 'DAV:' )
    {
        if ( isset( $this->properties[$namespace][$name] ) === true )
        {
            unset( $this->properties[$namespace][$name] );
        }
    }
    
    /**
     * Returns if the given property exists in the storage. 
     * Returns if the property with the given name is contained in the storage.
     * If the $namespace parameter is omited, the default DAV: namespace is
     * used.
     *
     * @param string $name
     * @param string $namespace
     * @return bool
     */
    public function contains( $name, $namespace = 'DAV:' )
    {
        return isset( $this->properties[$namespace][$name] );
    }

    /**
     * Returns a given property.
     * Returns the property with the given $name. If the $namespace parameter
     * is omitted, the default DAV: namespace is used. If the desired property
     * is not contained in the storage, null is returned.
     * 
     * @param string $name
     * @param string $namespace
     * @return ezcWebdavProperty|null
     */
    public function get( $name, $namespace ='DAV:' )
    {
        if ( isset( $this->properties[$namespace][$name] ) === true )
        {
            return $this->properties[$namespace][$name];
        }
        return null;
    }

    /**
     * Returns all properties of a given namespace.
     * The returned array is indexed by the property names. Live properties can
     * be accessed by simply ommiting the $namespace parameter.
     * 
     * @return array(string=>ezcWebdavProperty)
     */
    public function getProperties( $namespace = 'DAV:' )
    {
        if ( isset( $this->properties[$namespace] ) === false )
        {
            return array();
        }
        return $this->properties[$namespace];
    }

    /**
     * Returns all properties contained in the storage.
     * Returns the complete array stored in {@link $properties}.
     * 
     * @return array(string=>array(string=>ezcWebdavProperty))
     */
    public function getAllProperties()
    {
        return $this->properties;
    }
}

?>
