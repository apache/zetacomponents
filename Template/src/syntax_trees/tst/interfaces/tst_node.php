<?php
/**
 * File containing the ezcTemplateTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Node element for parser trees.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
abstract class ezcTemplateTstNode
{
    /**
     * @var ezcTemplateSourceCode
     */
    public $source;

    /**
     * The starting point for the node specified with a cursor
     *
     * @var ezcTemplateCursor
     */
    public $startCursor;

    /**
     * The end point for the node specified with a cursor.
     *
     * @var ezcTemplateCursor
     */
    public $endCursor;

    /**
     * An array containing the properties of this object.
     * originalText - The text string contained within the self::$startCursor and self::$endCursor.
     *                This text is never modified, if the propery is false it will read from the
     *                source code and set before being returned.
     *
     * @var array
     */
    private $properties = array( 'originalText' => false );

    /**
     * Initialize with the source code and start/stop cursors.
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        $this->source = $source;
        $this->startCursor = $start;
        $this->endCursor = $end;
    }

    /**
     * Property get
     */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'originalText':
                if ( $this->properties[$name] === false )
                    $this->properties[$name] = $this->startCursor->subString( $this->endCursor->position );
                return $this->properties[$name];
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property set
     */
    public function __set( $name, $value )
    {
        switch( $name )
        {
            case 'originalText':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property isset
     */
    public function __isset( $name )
    {
        switch( $name )
        {
            case 'originalText':
                return true;
            default:
                return false;
        }
    }


    /**
     * Returns the text portion from the original source code which is in the
     * area defined by the start and end cursor.
     * @return string
     */
    public function text()
    {
        return substr( $this->startCursor->text,
                       $this->startCursor->position,
                       $this->endCursor->position - $this->startCursor->position );
    }

    /**
     * Creates a representation of the operator and its parameters as a text
     * string and returns it.
     *
     * @note If any of the parameter is an operator it will call outputTree() on
     *       it, ie. recursive calls.
     * @param $level The current recursion level, initial call should start at 0.
     * @return string
     */
    public function outputTree( $level = 0 )
    {
        $text = "";
        $classText = "<" . preg_replace( "#^ezcTemplate(.+)Element$#", '$1', get_class( $this ) ) . ">";
        $cursorText = " @ " . $this->startCursor->line . ":" . $this->startCursor->column . "->" .
                              $this->endCursor->line . ":" . $this->endCursor->column;
        if ( method_exists( $this, 'symbol' ) )
        {
            $text .= "'" . $this->symbol() . "' " . $classText . $cursorText;
        }
        elseif ( $this instanceof ezcTemplateTypeTstNode )
        {
            $text = var_export( $this->value, true ) . " " . $classText . $cursorText;
        }
        elseif ( $this instanceof ezcTemplateVariableTstNode )
        {
            $text = '$' . $this->name . " " . $classText . $cursorText;
        }
        elseif ( $this instanceof ezcTemplateTextTstNode )
        {
            $text = '';
            $lines = explode( "\n", $this->text );
            foreach ( $lines as $i => $line )
            {
                if ( $i > 0 )
                    $text .= " . \"\\n\" .\n";
                $text .= "\"{$line}\"";
            }
            $text = "#text {$classText}{$cursorText}\n{$text}";
        }
        else
            $text .= $classText;

        if ( isset( $this->precedence ) )
            $text .= " (" . $this->precedence . ")\n";
        else
            $text .= "\n";

        if ( isset( $this->parameters ) )
            $parameters = $this->parameters;
        elseif ( isset( $this->elements ) )
            $parameters = $this->elements;
        else
            $parameters = false;

        if ( !is_array( $parameters ) )
            return $text;

        foreach ( $parameters as $i => $parameter )
        {
            if ( $i == count( $parameters ) - 1 )
            {
                $text .= '`-- ';
                $prefix = '    ';
            }
            else
            {
                $text .= '|-- ';
                $prefix = '|   ';
            }
            if ( !is_object( $parameter ) )
                throw new Exception( "Non-object <" . gettype( $parameter ) . "> found as parameter of object <" . get_class( $this ) . ">" );
//            if ( $parameter instanceof ezcTemplateOperatorTstNode )
                $parameterText = $parameter->outputTree( $level + 1 );
/*            elseif ( $parameter instanceof ezcTemplateTypeTstNode )
                $parameterText = $parameter->value;
            elseif ( $parameter instanceof ezcTemplateVariableTstNode )
                $parameterText = '$' . $parameter->name;
            elseif ( method_exists( $parameter, 'symbol' ) )
                $parameterText = $parameter->symbol();
            else
                $parameterText = preg_replace( "#^ezcTemplate(.+)Element$#", '$1', get_class( $parameter ) );*/

            $lines = explode( "\n", $parameterText );
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
     * Checks if the current element can be added as child of block object $block,
     * returns true if it can and false if not.
     *
     * @param ezcTemplateBlock $block The block object which should be the parent.
     * @return bool
     */
    abstract public function canBeChildOf( ezcTemplateBlockTstNode $block );

    /**
     * Figures out the indentation level of the element by checking the
     * whitespace of all lines. The minimum indentation level is returned.
     *
     * @return int
     */
    abstract public function minimumWhitespaceColumn();

    /**
     * Transforms the parse element into a code element which can be used to
     * generate PHP code.
     *
     * @retval ezcTemplateAstNode
     */
    //abstract public function transform();
    public function transform()
    {
        // temporary code until code elements are ready
        return false;
    }

    /**
     * The accept part for the visitor. 
     *
     * The sub classes don't need to implement the usual accept() method.
     *
     * If the current object is: ezcTemplateExpressionBlockTstNode then
     * the method: $visitor->visitExpressionBlockTstNode( $this )  will be called.
     */
    public function accept( ezcTemplateTstNodeVisitor $visitor  )
    {
        $class = get_class( $this );
        $visit = "visit" . substr( $class, 11 );

        return $visitor->$visit( $this );
    }

}
?>
