<?php
/**
 * File containing the ezcFeedTools class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Utility class providing useful functions to manipulate XML files.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedTools
{
    /**
     * Returns the value of attribute $name of the XML node $node, or null
     * if the attribute is not found.
     *
     * @param DOMNode $node The XML node
     * @param string $name The name of the attribute to return its value
     * @return mixed
     */
    public static function getAttribute( DOMNode $node, $name )
    {
        if ( $node->hasAttributes() )
        {
            foreach ( $node->attributes as $attribute )
            {
                if ( $attribute->name === $name )
                {
                    return $attribute->value;
                }
            }
        }

        return null;
    }

    /**
     * Returns an array containing the names and values of the attributes of
     * the XML node $node.
     *
     * @param DOMNode $node The XML node
     * @return array(string=>mixed)
     */
    public static function getAttributes( DOMNode $node )
    {
        $result = array();
        if ( $node->hasAttributes() )
        {
            foreach ( $node->attributes as $attribute )
            {
                $result[$attribute->name] = $attribute->value;
            }
        }

        return $result;
    }

    /**
     * Returns a DOMNode child of $parent with name $nodeName and which has an
     * attribute $attribute with the value $value. Returns null if no such node
     * is found.
     *
     * @param DOMNode $parent The XML parent node
     * @param string $nodeName The node name to find
     * @param string $attribute The attribute of the node
     * @param mixed $value The value of the attribute
     * @return DOMNode
     */
    public static function getNodeByAttribute( DOMNode $parent, $nodeName, $attribute, $value )
    {
        $result = null;
        $nodes = $parent->getElementsByTagName( $nodeName );

        foreach ( $nodes as $node )
        {
            $nodeAttribute = ezcFeedTools::getAttribute( $node, $attribute );
            if ( $nodeAttribute !== null
                 && $nodeAttribute === $value )
            {
                $result = $node;
                break;
            }
        }

        return $result;
    }

    /**
     * Returns the provided $date in timestamp format.
     *
     * @param mixed $date A date
     * @return int
     */
    public static function prepareDate( $date )
    {
        if ( is_int( $date ) || is_numeric( $date ) )
        {
            return $date;
        }
        $ts = strtotime( $date );
        if ( $ts !== false )
        {
            return $ts;
        }
        return time();
    }

    /**
     * Returns the name on which $name is mapped in the $mappingArray array,
     * or $name if a mapping does not exist for it.
     *
     * @param string $name The element name to normalize
     * @param array(string=>string) $mappingArray A mapping of attribute names to normalized names
     * @return string
     */
    public static function normalizeName( $name, array $mappingArray )
    {
        if ( array_key_exists( $name, $mappingArray ) )
        {
            return $mappingArray[$name];
        }
        return $name;
    }

    /**
     * Returns the name on which $attributeName is mapped in the $mappingArray
     * flipped array, or $attributeName if a mapping does not exist for
     * $attributeName.
     *
     * @param string $name The element name to denormalize
     * @param array(string=>string) $mappingArray A mapping of attribute names to normalized names
     * @return string
     */
    public static function deNormalizeName( $name, $mappingArray )
    {
        return self::normalizeName( $name, array_flip( $mappingArray ) );
    }
}
?>
