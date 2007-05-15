<?php

class ezcBaseTestOptions extends ezcBaseOptions
{
    protected $properties = array( "foo" => "bar" );

    public function __set( $propertyName, $propertyValue )
    {
        if ( $this->__isset( $propertyName ) )
        {
            $this->properties[$propertyName] = $propertyValue;
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }
}

?>
