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
 * Utility class providing useful functions to manipulate XML files, date
 * functions and functions to normalize/denormalize feed element names.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedTools
{
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
            $nodeAttribute = $node->getAttribute( $attribute );
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
     * Returns the provided $date (timestamp, string or DateTime object) as a
     * DateTime object.
     *
     * It preserves the timezone if $date contained timezone information.
     *
     * @param mixed $date A date specified as a timestamp, string or DateTime object
     * @return DateTime
     */
    public static function prepareDate( $date )
    {
        if ( is_numeric( $date ) )
        {
            return new DateTime( "@{$date}" );
        }
        else if ( $date instanceof DateTime )
        {
            return $date;
        }
        else
        {
            try
            {
                $d = new DateTime( $date );
            }
            catch ( Exception $e )
            {
                return new DateTime();
            }

            return $d;
        }
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
        if ( isset( $mappingArray[$name] ) )
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
