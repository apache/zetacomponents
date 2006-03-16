<?php
/**
 * File containing the ezcTemplateTstTreeDump class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Iterates the TST tree and dumps the result as text.
 *
 * Implements the ezcTemplateTstNodeVisitor interface for visiting the nodes
 * and generating the appropriate ast nodes for them.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTstTreeDump implements ezcTemplateTstNodeVisitor
{
    /**
     * @var string $text Will contain the dumped tree.
     */
    public $text;

    public function __construct()
    {
        $this->text = '';
    }

    static public function dump( ezcTemplateTstNode $node )
    {
        $treeDump = new ezcTemplateTstTreeDump();
        $node->accept( $treeDump );
        return $treeDump->text . "\n";
    }

    public function visitProgramTstNode( ezcTemplateProgramTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitExpressionBlockTstNode( ezcTemplateExpressionBlockTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitTypeTstNode( ezcTemplateTypeTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitConditionalOperatorTstNode( ezcTemplateConditionalOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $node )
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    public function visitBlockTstNode( ezcTemplateBlockTstNode $node ) 
    {
        $this->text .= $this->dumpTstNode( $node );
    }

    /**
     * Dumps the contents of any TST node.
     *
     * Will display the name of the node, the position in the file and then dump
     * all the properties.
     *
     * @param ezcTemplateTstNode $node The TST node to dump.
     * @return string
     */
    protected function dumpTstNode( ezcTemplateTstNode $node )
    {
        $text  = "<" . preg_replace( "#^ezcTemplate(.+)TstNode#", '$1', get_class( $node ) ) . ">";
        $text .= " @ " . $node->startCursor->line . ":" . $node->startCursor->column . "->" .
                         $node->endCursor->line . ":" . $node->endCursor->column;
        $text .= "\n";
        $properties  = $node->treeProperties;
        $text .= $this->dumpArray( $properties, true );
        return $text;
    }

    /**
     * Dumps the array as a tree structure.
     *
     * For instance the array:
     * <code>
     * array( 'name'      => 'foo',
     *        'type'      => 'bar',
     *        'isEnabled' => true );
     * </code>
     * will become:
     * <code>
     * |-- name:      "foo"
     * |-- type:      "bar"
     * `-- isEnabled: true
     * </code>
     *
     * It can also handle arrays and objects which will be dumped recursively.
     * For objects it will dump the properties if it is an ezcTemplateTstNode
     * by calling dumpTstNode() while array is dumped by calling dumpArray().
     * All other objects will be cast to a string and dumped.
     *
     * Dumping an array with array:
     * <code>
     * array( 'children' => array( 'foo', 'bar' ) );
     * </code>
     * will become:
     * <code>
     * `-- children: array[2]
     *     |-- "foo"
     *     `-- "bar"
     * </code>
     *
     * Dumping an array with objects:
     * <code>
     * array( 'children' => array( new ezcTemplateTypeTstNode( 5 ),
     *                             new ezcTemplateTextBlockTstNode( "line1\nline2" ) ) );
     * </code>
     * will become:
     * <code>
     * `-- children: array[2]
     *     |-- <Type> @ 1:0->2:0
     *     |   `-- value: 5
     *     `-- <TextBlock> @ 2:0->3:0
     *         "line1" . "\n" .
     *         "line2"
     * </code>
     *
     * @param array $properties The array to dump
     * @param bool  $useKey     If true then the keys of the array is displayed.
     * @return string
     */
    protected function dumpArray( $properties, $useKey )
    {
        $text = '';
        $maxLen = 0;
        if ( $useKey )
        {
            foreach ( $properties as $name => $property )
            {
                $maxLen = max( strlen( $name ), $maxLen );
            }
        }
        $i = 0;
        foreach ( $properties as $name => $property )
        {
            if ( $i > 0 )
            {
                $text .= "\n";
            }

            $remainderText   = '';
            $remainderWsText = '';
            if ( $useKey )
            {
                $remainder = $maxLen - strlen( $name );
                if ( $remainder > 0 )
                {
                    $remainderText   = str_repeat( '-', $remainder );
                    $remainderWsText = str_repeat( ' ', $remainder );
                }
            }

            $suffix = '';
            if ( $useKey )
            {
                $suffix = $name . $remainderWsText . ': ';
            }
            if ( $i == count( $properties ) - 1 )
            {
                $text   .= '`-- ' . $suffix;
                $prefix  = '    ';
            }
            else
            {
                $text   .= '|-- ' . $suffix;
                $prefix  = '|   ';
            }

            // if $textBlock contains a string it will be display in between
            // properties using $prefix for each line.
            $textBlock = false;
            if ( is_object( $property ) )
            {
                if ( $property instanceof ezcTemplateTstNode )
                {
                    $textBlock = $this->dumpTstNode( $property, true );
                }
                else
                {
                    $text .= (string)$property;
                }
            }
            elseif ( is_array( $property ) )
            {
                $text .= "array[" . count( $property ) . "]";
                $textBlock = $this->dumpArray( $property, false );
            }
            elseif ( is_string( $property ) )
            {
                if ( strpos( $property, "\n" ) === false )
                {
                    $line = self::dumpString( $property );
                    $text .= "\"{$line}\"";
                }
                else
                {
                    $lines = explode( "\n", $property );
                    foreach ( $lines as $offset => $line )
                    {
                        if ( $offset > 0 )
                            $textBlock .= " . \"\\n\" .\n";
                        $line = self::dumpString( $line );
                        $textBlock .= "\"{$line}\"";
                    }
                }
            }
            else
            {
                $text .= var_export( $property, true );
            }
            if ( $textBlock !== false )
            {
                // Split into lines and output each with the $prefix value in front.
                $lines = explode( "\n", $textBlock );
                $start = 0;
                if ( $useKey )
                {
                    $text .= "\n";
                }
                else
                {
                    $start = 1;
                    $text .= $lines[0] . "\n";
                }
                for ( $line = $start; $line < count( $lines ); ++$line )
                {
                    if ( $line > $start )
                        $text .= "\n";
                    $text .=  $prefix . $lines[$line];
                }
            }

            ++$i;
        }
        return $text;
    }

    /**
     * Dumps the string by escaping special characters making them readable.
     *
     * The special characters are: \n, \r, \t, \b, \" and '
     * @param string $str The string to dump.
     * @return string
     */
    protected static function dumpString( $str )
    {
        return str_replace( array( "\n",  "\r",  "\t",  "\b",  "\"",   "'" ),
                            array( "\\n", "\\r", "\\t", "\\b", "\\\"", "\\'" ),
                            $str );
    }
}
?>
