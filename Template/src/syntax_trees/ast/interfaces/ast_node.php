<?php
/**
 * File containing the ezcTemplateAstNode abstract class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class for representing PHP code elements as objects.
 *
 * When inheriting this class the sub-class must make sure the getSubElements()
 * is implemented. This can either return the internal $parameters list or
 * generate it on demand from the specific member variables which are in use.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
abstract class ezcTemplateAstNode
{
    /**
     */
    public function __construct()
    {
    }

    /**
     * Returns the sub-elements of the code element.
     *
     * This must be re-implemented to return all sub-elements for the current
     * element as an array of code elements. This method is used by the
     * getTreeRepresentation() method to generate an overview of all
     * sub-elements.
     * @note The values returned from this method must never be modified.
     *
     * @return array(ezcTemplateAstNode)
     */
    abstract public function getSubElements();

    /**
     * Creates a representation of the operator and its parameters as a text
     * string and returns it.
     *
     * @param $level The current recursion level, initial call should start at 0.
     * @return string
     */
    public function getTreeRepresentation( $level = 0 )
    {
        $classText = "[" . preg_replace( "#^ezcTemplate(.+)AstNode#", '$1', get_class( $this ) ) . "]";
        $codeSymbol = $this->getRepresentation();

        $text = "{$codeSymbol} {$classText}\n";
        $elements = $this->getSubElements();
        foreach ( $elements as $i => $element )
        {
            if ( $i == count( $elements ) - 1 )
            {
                $text .= '`-- ';
                $prefix = '    ';
            }
            else
            {
                $text .= '|-- ';
                $prefix = '|   ';
            }
            if ( $element === null )
            {
                $elementText = "NULL";
            }
            elseif ( !is_object( $element ) )
            {
                throw new Exception( "Non-object <" . gettype( $element ) . "> found as element of object <" . get_class( $this ) . ">" );
            }
            else
            {
                $elementText = $element->getTreeRepresentation( $level + 1 );
            }

            $lines = explode( "\n", $elementText );
            $text .= $lines[0];
            // Last line is a newline only so we skip it
            for ( $line = 1; $line < count( $lines ) - 1; ++$line )
            {
                $text .= "\n" . $prefix . $lines[$line];
            }
            $text .= "\n";
        }
        return $text;
    }

    /**
     * Generates a representation of the current element and returns it.
     *
     * The represenatation is part of the tree showing how code elements
     * are built. This mostly useful for debugging.
     *
     * @return string
     */
    abstract public function getRepresentation();

    /**
     * Checks if the visitor object is accepted and if so calls the appropriate
     * visitor method in it.
     *
     * All sub-classes must reimplement this and check if the $visitor object
     * implements the required interface and if so call the appropriate method.
     * The generic code for this method is:
     * <code>
     * if ( $visitor instanceof ezcTemplateBasicAstNodeVisitor )
     * {
     *     $visitor->visitAstNode( $this );
     * }
     * </code>
     * Just replace ezcTemplateBasicAstNodeVisitor with the interface which has the
     * the required method and the visitAstNode() call with the correct method.
     *
     * @param ezcTemplateBasicAstNodeVisitor $visitor
     *        The visitor object which can visit the current code element.
     */
    abstract public function accept( ezcTemplateAstNodeVisitor $visitor );
}
?>
