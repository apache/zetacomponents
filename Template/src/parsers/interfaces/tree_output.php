<?php
/**
 * File containing the ezcTemplateTreeOutput abstract class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Iterates the given tree and outputs the result as text.
 *
 * This class must be extended and combined with a visitor (e.g. ezcTemplateTstNodeVisitor)
 * to create a specific tree visitor for outputting the tree structure.
 *
 * This class has some abstract functions which must be implemented by the
 * extending class, they are used to gain more detailed information about tree
 * nodes.
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
 * It can also handle arrays and objects which will be output recursively.
 * For objects it will output the properties if it is an instance of $this->nodeClass
 * by calling outputNode() while array is output by calling outputArray().
 * All other objects will be cast to a string and output.
 *
 * Outputting an array with array:
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
 * Outputting an array with objects:
 * <code>
 * array( 'children' => array( new ezcTemplateLiteralTstNode( 5 ),
 *                             new ezcTemplateTextBlockTstNode( "line1\nline2" ) ) );
 * </code>
 * will become:
 * <code>
 * `-- children: array[2]
 *     |-- <Literal> @ 1:0->2:0
 *     |   `-- value: 5
 *     `-- <TextBlock> @ 2:0->3:0
 *         "line1" . "\n" .
 *         "line2"
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
abstract class ezcTemplateTreeOutput
{
    /**
     * @var string $text Will contain the output tree.
     */
    public $text;

    /**
     * The name of the class which all nodes inherit from.
     */
    public $nodeClass;

    public function __construct( $nodeClass )
    {
        $this->text      = '';
        $this->nodeClass = $nodeClass;
    }

    /**
     * Extracts the name of the node and returns it as a string.
     *
     * @note Reimplement this to handle the node properly.
     *
     * @param Object $node The node to examine.
     * @return string
     */
    abstract protected function extractNodeName( $node );

    /**
     * Extracts position data from the specified node and set in the out parameters.
     *
     * @note Reimplement this to handle the node properly.
     *
     * @param Object $node The node to examine.
     * @param int    $startLine   The starting line for the node.
     * @param int    $startColumn The starting column for the node.
     * @param int    $endLine     The starting line for the node.
     * @param int    $endColumn   The starting column for the node.
     * @return bool True if the extraction was succesful.
     */
    abstract protected function extractNodePosition( $node, &$startLine, &$startColumn, &$endLine, &$endColumn );

    /**
     * Extracts the properties from the specified node and returns it as an array.
     *
     * @note Reimplement this to handle the node properly.
     *
     * @param Object $node The node to examine.
     * @return array(name=>value)
     */
    abstract protected function extractNodeProperties( $node );

    /**
     * Outputs the contents of any node.
     *
     * Will display the name of the node, the position in the file and then output
     * all the properties.
     *
     * @param  Object $node The node to output.
     * @return string
     * @see extractNodeName()
     * @see extractNodePosition()
     * @see extractNodeProperties()
     */
    protected function outputNode( $node )
    {
        $text  = "<" . $this->extractNodeName( $node ) . ">";
        if ( $this->extractNodePosition( $node, $startLine, $startColumn,
                                                $endLine, $endColumn ) )
        {
            $text .= " @ " . $startLine . ":" . $startColumn . "->" .
                             $endLine   . ":" . $endColumn;
        }
        $text .= "\n";
        $properties  = $this->extractNodeProperties( $node );
        $text .= $this->outputArray( $properties, true );
        return $text;
    }

    /**
     * Outputs the array as a tree structure (recursively).
     *
     * @param array $properties The array to output
     * @param bool  $useKey     If true then the keys of the array is displayed.
     * @return string
     */
    protected function outputArray( $properties, $useKey )
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

            $remainderWsText = '';
            $remainder = $maxLen - strlen( $name );
            if ( $useKey && $remainder > 0 )
            {
                $remainderWsText = str_repeat( ' ', $remainder );
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
                if ( $property instanceof $this->nodeClass )
                {
                    $textBlock = $this->outputNode( $property, true );
                }
                else
                {
                    $text .= (string)$property;
                }
            }
            elseif ( is_array( $property ) )
            {
                $text .= "array[" . count( $property ) . "]";
                $textBlock = $this->outputArray( $property, false );
            }
            elseif ( is_string( $property ) )
            {
                if ( strpos( $property, "\n" ) === false )
                {
                    $line = self::outputString( $property );
                    $text .= "\"{$line}\"";
                }
                else
                {
                    $lines = explode( "\n", $property );
                    foreach ( $lines as $offset => $line )
                    {
                        if ( $offset > 0 )
                            $textBlock .= " . \"\\n\" .\n";
                        $line = self::outputString( $line );
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
     * Outputs the string by escaping special characters making them readable.
     *
     * The special characters are: \n, \r, \t, \b, \" and '
     * @param string $str The string to output.
     * @return string
     */
    protected static function outputString( $str )
    {
        return str_replace( array( "\n",  "\r",  "\t",  "\b",  "\"",   "'" ),
                            array( "\\n", "\\r", "\\t", "\\b", "\\\"", "\\'" ),
                            $str );
    }
}
?>
