<?php
/**
 * File containing the ezcReflectionTypeFactoryImpl class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Implements type mapping from string to ezcReflectionType
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionTypeFactoryImpl implements ezcReflectionTypeFactory {

    /**
     * @var ezcReflectionTypeMapper
     */
    protected $mapper;

    /**
     * Constructs a type factory implementation
     */
    public function __construct() {
        $this->mapper = ezcReflectionTypeMapper::getInstance();
    }

    /**
     * Creates a type object for given type name
     * @param string|ReflectionClass $typeName
     * @return ezcReflectionType
     * @todo ArrayAccess stuff, how to handle? has to be implemented
     */
    public function getType( $typeName )
    {
        if ( $typeName instanceof ReflectionClass )
        {
            return new ezcReflectionObjectType( $typeName );
        }
        $typeName = trim( $typeName );
        if ( empty( $typeName ) ) {
            return null;
        }
        elseif (
            $this->mapper->isScalarType( $typeName )
            or $this->mapper->isSpecialType( $typeName )
        )
        {
            return new ezcReflectionPrimitiveType( $typeName );
        }
        elseif ( $this->mapper->isArray( $typeName ) )
        {
            return new ezcReflectionArrayType( $typeName );
        }
        elseif ( $this->mapper->isMixed( $typeName ) )
        {
            return new ezcReflectionMixedType( $typeName );
        }
        else {
		    // otherwhise it has to be a class name
		    return new ezcReflectionObjectType( $typeName );
        }
    }
}

?>
