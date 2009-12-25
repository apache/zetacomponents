<?php
/**
 * File containing the ezcReflectionMixedType class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Representation for the mixed type
 *
 * @package Reflection
 * @version //autogen//
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionMixedType extends ezcReflectionAbstractType {

    /**
     * @var ezcReflectionType[]
     */
    protected $types;
    
    /**
     * Returns a list of types
     * 
     * @return ezcReflectionType[]
     */
    public function getTypes()
    {
        if ( is_null( $this->types ) )
        {
            $typeName = parent::getTypeName();
            if ( $typeName == ezcReflectionTypeMapper::CANONICAL_NAME_NUMBER )
            {
                $this->type = array(
                    ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_INTEGER ),
                    ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_FLOAT ),
                );
            }
            elseif ( $typeName == ezcReflectionTypeMapper::CANONICAL_NAME_CALLBACK )
            {
                $this->type = array(
                    ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_STRING ),
                    ezcReflectionApi::getTypeByName( 'mixed[]' ), // TODO Change this to 'array(integer=>object|string)'
                    ezcReflectionApi::getTypeByName( 'Closure' ),
                );
            }
            else
            {
                $this->type = array();
            }
        }
        return $this->types;
    }
    
    /**
     * Return the name of this type as string
     *
     * @return string
     */
    public function getTypeName()
    {
        $typeName = parent::getTypeName();
        if (
            $typeName != ezcReflectionTypeMapper::CANONICAL_NAME_NUMBER
            and $typeName != ezcReflectionTypeMapper::CANONICAL_NAME_CALLBACK
        )
        {
            $types = $this->getTypes();
            if ( !empty( $types ) )
            {
                $typeName = '';
                foreach ( $types as $type )
                {
                    $typeName .= $type->getTypeName() . '|';
                }
                $typeName = substr( $typeName, 0, -1 ); // remove last '|'
            }
        }
        return $typeName;
    }

}
?>
