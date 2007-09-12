<?php

class ezcWebdavPropertyStorage extends SplObjectStorage
{
    /**
     * Attaches a property to the storage.
     * Performs a check if $property is a valid {@link ezcWebdavProperty} and
     * attaches the object afterwards.
     * 
     * @param ezcWebdavProperty $property 
     * @return void
     */
    public function attach( $property )
    {
        if ( ( $property instanceof ezcWebdavProperty ) === false )
        {
            throw new ezcBaseValueException(
                'property',
                $property,
                'ezcWebdavProperty'
            );
        }
        parent::attach( $property );
    }
    
    /**
     * Detaches a property from the storage.
     * Performs a check if $property is a valid {@link ezcWebdavProperty} and
     * detaches the object afterwards.
     * 
     * @param ezcWebdavProperty $property 
     * @return void
     */
    public function detach( $property )
    {
        if ( ( $property instanceof ezcWebdavProperty ) === false )
        {
            throw new ezcBaseValueException(
                'property',
                $property,
                'ezcWebdavProperty'
            );
        }
        parent::detach( $property );
    }
    
    /**
     * Returns if the given property exists in the storage.  Performs a check
     * if $property is a valid {@link ezcWebdavProperty} and checks if it (the
     * very same object) is contained in the storage.
     * 
     * @param ezcWebdavProperty $property 
     * @return bool
     */
    public function contains( $property )
    {
        if ( ( $property instanceof ezcWebdavProperty ) === false )
        {
            throw new ezcBaseValueException(
                'property',
                $property,
                'ezcWebdavProperty'
            );
        }
        return parent::contains( $property );
    }
}

?>
