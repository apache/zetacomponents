<?php

class ezcPersistentPropertyTestFloatConverter implements ezcPersistentPropertyConverter
{
    public function fromDatabase( $databaseValue )
    {
        if ( $databaseValue === null )
        {
            return 42.23;
        }
        return (float) $databaseValue;
    }

    public function toDatabase( $propertyValue )
    {
        if ( $propertyValue === null )
        {
            return 23.42;
        }
        return (float) $propertyValue;
    }

    public static function __set_state( array $state )
    {
        return new ezcPersistentPropertyTestFloatConverter();
    }
}

?>
