<?php
/**
 * File containing the ezcWebdavBasicPropertyStorage class.
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
class ezcWebdavBasicPropertyStorage implements ezcWebdavPropertyStorage
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
     * Stores a list of the assigned properties in the order they were
     * assigned, to make this order accessible for the Iterator.
     * 
     * @var array
     */
    protected $propertyOrder = array();

    /**
     * Current position of the iterator in the ordered property list.
     * 
     * @var int
     */
    protected $propertyOrderPosition = 0;

    /**
     * Next ID for a element in the ordered property list, to generate valid
     * IDs even when some contents has been removed.
     * 
     * @var int
     */
    protected $propertyOrderNextId = 0;

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
        // Update list of ordered properties
        if ( ( isset( $this->properties[$property->namespace] ) === false ) ||
             ( isset( $this->properties[$property->namespace][$property->name] ) === false ) )
        {
            $this->propertyOrder[$this->propertyOrderNextId++] = array( $property->namespace, $property->name );
        }

        // Add property
        $this->properties[$property->namespace][$property->name] = $property;
    }
    
    /**
     * Detaches a property from the storage.
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
    public function get( $name, $namespace = 'DAV:' )
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

    /**
     * Diff two property storages.
     *
     * Return the current property storage reduced by the elements in the given
     * property storage.
     * 
     * @param ezcWebdavBasicPropertyStorage $properties 
     * @return ezcWebdavBasicPropertyStorage
     */
    public function diff( ezcWebdavPropertyStorage $properties )
    {
        $foreign = $properties->getAllProperties();

        $diffedProperties = new ezcWebdavBasicPropertyStorage();
        foreach ( $this->properties as $namespace => $properties )
        {
            foreach( $properties as $name => $property )
            {
                if ( !isset( $foreign[$namespace][$name] ) )
                {
                    // Only add properties to new property storage, which could
                    // not be found in the foreign property storage.
                    $diffedProperties->attach( $property );
                }
            }
        }

        return $diffedProperties;
    }

    /**
     * Intersection between two property storages.
     *
     * Calculate and return {@link ezcWebdavBasicPropertyStorage} which returns the
     * intersection of two property storages. This means a new property storage
     * will be return which contains all values, which are present in the
     * current and the gi ven property storage.
     * 
     * @param ezcWebdavBasicPropertyStorage $properties 
     * @return ezcWebdavBasicPropertyStorage
     */
    public function intersect( ezcWebdavPropertyStorage $properties )
    {
        $foreign = $properties->getAllProperties();

        $intersection = new ezcWebdavBasicPropertyStorage();
        foreach ( $this->properties as $namespace => $properties )
        {
            foreach( $properties as $name => $property )
            {
                if ( isset( $foreign[$namespace][$name] ) )
                {
                    // Only add properties to new property storage, which could
                    // be found in both property storages.
                    $intersection->attach( $property );
                }
            }
        }

        return $intersection;
    }

    /**
     * Methods required for Countable
     */

    /**
     * Return property count.
     *
     * Implementation required by interface Countable. Count the numbers of
     * item contained by this class. Will return the item count ignoring their
     * namespace.
     * 
     * @return int
     */
    public function count()
    {
        $count = 0;
        foreach ( $this->properties as $properties )
        {
            $count += count( $properties );
        }
        
        return $count;
    }

    /**
     * Methods required for Iterator
     */

    /**
     * Implements current() for Iterator
     * 
     * @return mixed
     */
    public function current()
    {
        list( $namespace, $name ) = $this->propertyOrder[$this->propertyOrderPosition];

        // Skip detached properties
        while ( !isset( $this->properties[$namespace][$name] ) )
        {
            if ( !isset( $this->propertyOrder[++$this->propertyOrderPosition] ) )
            {
                // We reached the end.
                return false;
            }

            list( $namespace, $name ) = $this->propertyOrder[$this->propertyOrderPosition];
        }

        return $this->properties[$namespace][$name];
    }

    /**
     * Implements key() for Iterator
     * 
     * @return int
     */
    public function key()
    {
        return $this->propertyOrderPosition;
    }

    /**
     * Implements next() for Iterator
     * 
     * @return mixed
     */
    public function next()
    {
        do 
        {
            if ( !isset( $this->propertyOrder[++$this->propertyOrderPosition] ) )
            {
                // We reached the end.
                return false;
            }

            list( $namespace, $name ) = $this->propertyOrder[$this->propertyOrderPosition];
        } // Skip detached properties
        while ( !isset( $this->properties[$namespace][$name] ) );

        return $this->properties[$namespace][$name];
    }

    /**
     * Implements rewind() for Iterator
     * 
     * @return void
     */
    public function rewind()
    {
        $this->propertyOrderPosition = 0;
    }

    /**
     * Implements valid() for Iterator
     * 
     * @return boolean
     */
    public function valid()
    {
        return ( $this->propertyOrderPosition < $this->propertyOrderNextId );
    }
}

?>
