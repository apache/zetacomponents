<?php
/**
 * File containing the ezcWebdavFlaggedPropertyStorage class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to manage instances of ezcWebdavProperty with associated flags.
 *
 * The stored objects are associated with some user defined flags. Other then
 * that the class does what {@link ezcWebdavPropertyStorage} does.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavFlaggedPropertyStorage extends ezcWebdavBasicPropertyStorage
{
    /**
     * Next ID for a element in the ordered property list, to generate valid
     * IDs even when some contents has been removed.
     * 
     * @var array
     */
    protected $flags = array();

    /**
     * Attaches a property to the storage.
     *
     * Adds the given $property to the storage. The property can later be
     * accessed by its name in combination with the namespace. Live properties
     * (and only these) reside in the namespace DAV:, which is the default for
     * all accessor methods.
     *
     * If a property with the same namespace and name is already contained in
     * the storage, it will be overwritten.
     *
     * You may optionally add some flag of mixed type to the property, which
     * just be stored and may be requested later.
     * 
     * @param ezcWebdavProperty $property 
     * @param mixed $flag 
     * @return void
     */
    public function attach( ezcWebdavProperty $property, $flag = 0 )
    {
        // Update list of ordered properties
        if ( ( isset( $this->properties[$property->namespace] ) === false ) ||
             ( isset( $this->properties[$property->namespace][$property->name] ) === false ) )
        {
            $this->propertyOrder[$this->propertyOrderNextId++] = array( $property->namespace, $property->name );
        }

        // Add property
        $this->properties[$property->namespace][$property->name] = $property;
        $this->flags[$property->namespace][$property->name] = $flag;
    }
    
    /**
     * Detaches a property from the storage.
     *
     * Removes the property with the given $name from the storage. If the
     * property did not exist in the storage, the call is silently ignored. If
     * no $namespace is given, the default namespace DAV: is used.
     * 
     * @param string $name 
     * @param string $namespace
     * @return void
     */
    public function detach( $name, $namespace = 'DAV:' )
    {
        if ( ( isset( $this->properties[$namespace] ) === true ) &&
             ( isset( $this->properties[$namespace][$name] ) === true ) )
        {
            unset( $this->properties[$namespace][$name] );
            unset( $this->flags[$namespace][$name] );
        }
    }
    
    /**
     * Get flags for property.
     *
     * Get the flags of a proerpty from the flagged property storage by its
     * name and optionally the naemspace of the property. If the namespace is
     * not explicitely given it dafults to the default DAV namespace "DAV:".
     *
     * Will return null, if no flag has been assigned, or the property does not
     * exist.
     * 
     * @param string $name 
     * @param string $namespace
     * @return mixed
     */
    public function getFlag( $name, $namespace = 'DAV:' )
    {
        if ( ( isset( $this->properties[$namespace] ) === true ) &&
             ( isset( $this->properties[$namespace][$name] ) === true ) )
        {
            return $this->flags[$namespace][$name];
        }

        return null;
    }
}

?>
