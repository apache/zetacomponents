<?php
/**
 * File containing the ezcTemplateTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Node element for parser trees.
 *
 * @package Template
 * @version //autogen//
 * @access private
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
    private $properties = array( 'originalText' => false,
                                 'treeProperties' => false );

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
        switch ( $name )
        {
            case 'originalText':
                if ( $this->properties[$name] === false )
                    $this->properties[$name] = $this->startCursor->subString( $this->endCursor->position );
                return $this->properties[$name];
            case 'treeProperties':
                return $this->getTreeProperties();
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property set
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'originalText':
            case 'treeProperties':
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
        switch ( $name )
        {
            case 'originalText':
            case 'treeProperties':
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
     * Returns an array with all properties related to the node tree.
     *
     * Note: This must be reimplemented by sub-classes.
     */
    abstract public function getTreeProperties();

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


    public function handleElement( ezcTemplateTstNode $element )
    {
        return false;
    }

    public function canAttachToParent( $parentElement )
    {
    }


    /**
     * The accept part for the visitor.
     *
     * The sub classes don't need to implement the usual accept() method.
     *
     * If the current object is: ezcTemplateOutputBlockTstNode then
     * the method: $visitor->visitOutputBlockTstNode( $this ) will be called.
     */
    public function accept( ezcTemplateTstNodeVisitor $visitor  )
    {
        $class = get_class( $this );
        $visit = "visit" . substr( $class, 11 );

        $res = $visitor->$visit( $this );
        return $res;
    }
}
?>
