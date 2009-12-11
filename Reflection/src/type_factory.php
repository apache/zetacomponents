<?php
/**
 * File containing the ezcReflectionTypeFactoryImpl class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
     * @param string $typeName
     * @return ezcReflectionType
     * @todo ArrayAccess stuff, how to handle? has to be implemented
     */
    public function getType($typeName) {
        $typeName = trim($typeName);
        // For void null is returned
        if ($typeName == null or strlen($typeName) < 1 or strtolower($typeName) == 'void') {
            return null;
        }
        // First check whether it is a primitive type
        if ($this->mapper->isPrimitive($typeName)) {
            return new ezcReflectionPrimitiveType($this->mapper->getType($typeName));
        }
        // then check whether it is an array type
        elseif ($this->mapper->isArray($typeName)) {
            return new ezcReflectionArrayType($typeName);
        }
        // then check whether it is a mixed type
        elseif ( $this->mapper->isMixed( $typeName ) )
        {
            return new ezcReflectionMixedType( $typeName );
        }
        // otherwhise it has to be a user class
		else {
            return new ezcReflectionClassType($typeName);
        }
    }
}

?>
