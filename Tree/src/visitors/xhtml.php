<?php
/**
 * File containing the ezcTreeVisitorXHTML class.
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An implementation of the ezcTreeVisitor interface that generates
 * an XHTML representatation of a tree structure.
 *
 * <code>
 * <?php
 *     $visitor = new ezcTreeVisitorXHTML( 'menu_tree', 'menu' );
 *     $tree->accept( $visitor );
 *     echo (string) $visitor; // print the plot
 * ?>
 * </code>
 *
 * Shows (something like):
 * <code>
 * </code>
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeVisitorXHTML implements ezcTreeVisitor
{
    /**
     * Holds all the edges of the graph.
     *
     * @var array(string=>array(string))
     */
    protected $edges = array();

    /**
     * Holds the root ID
     *
     * @var string
     */
    protected $root = null;

    /**
     * Holds the XML ID
     *
     * @var string
     */
    protected $id;

    /**
     * Holds the XHTML class
     *
     * @var string
     */
    protected $class;

    /**
     * Whether the XML ID has been set
     *
     * @var bool
     */
    private $treeIdSet;

    /**
     * Constructs a new ezcTreeVisitorXHTML visualizer using $symbolCharset as character set
     *
     * This class only supports 'ascii' and 'utf-8' as character sets.
     * @see SYMBOL_UTF8
     * @see SYMBOL_ASCII
     *
     * @param int $symbolCharset
     */
    public function __construct( ezcTreeVisitorXHTMLOptions $options = null )
    {
        if ( $options === null )
        {
            $this->options = new ezcTreeVisitorXHTMLOptions;
        }
        else
        {
            $this->options = $options;
        }
    }

    /**
     * This method formats a node's data.
     *
     * It is just a simple method, that provide an easy way to change the way
     * on how data is formatted when this class is extended.
     *
     * @param mixed $data
     * @return string
     */
    protected function formatData( $data )
    {
        return $data;
    }

    /**
     * Visits the node and sets the the member variables according to the node
     * type and contents.
     *
     * @param ezcTreeVisitable $visitable
     * @return boolean
     */
    public function visit( ezcTreeVisitable $visitable )
    {
        if ( $visitable instanceof ezcTree )
        {
        }

        if ( $visitable instanceof ezcTreeNode )
        {
            if ( $this->root === null )
            {
                $this->root = $visitable->id;
            }

            $parent = $visitable->fetchParent();
            if ( $parent )
            {
                $this->edges[$parent->id][] = array( $visitable->id, $visitable->data, $visitable->fetchPath() );
            }
        }

        return true;
    }

    /**
     * Loops over the children of the node with ID $id.
     *
     * This methods loops over all the node's children and adds the correct
     * layout for each node depending on the state that is collected in the
     * $level and $levelLast variables.
     *
     * @param string $id
     * @param int    $level
     * @param array(int=>bool) $levelLast
     *
     * @return string
     */
    protected function doChildren( $id, $level = 0, $levelLast = array() )
    {
        $text = '';

        $children = $this->edges[$id];
        $numChildren = count( $children );

        if ( $numChildren > 0 )
        {
            $text .= str_repeat( '  ', $level + 1 );

            $idPart = '';
            if ( !$this->treeIdSet )
            {
                $idPart = $this->options->xmlId ? " id=\"{$this->options->xmlId}\"" : '';
                $this->treeIdSet = true;
            }
            $text .= "<ul{$idPart}>\n";
            foreach ( $children as $child )
            {
                $path = $child[2]->nodes;
                if ( !$this->options->displayRootNode )
                {
                    array_shift( $path );
                }
                $path = htmlspecialchars( $this->options->basePath . '/' . join( '/', $path ) );
                $text .= str_repeat( '  ', $level + 2 );

                $data = htmlspecialchars( $this->formatData( $child[1] ) );

                $linkStart = $linkEnd = '';
                if ( $this->options->addLinks )
                {
                    $linkStart = "<a href=\"{$path}\">";
                    $linkEnd   = "</a>";
                }

                $highlightPart = '';
                if ( in_array( $child[0], $this->options->highlightNodeIds ) )
                {
                    $highlightPart = ' class="highlight"';
                }

                if ( isset( $this->edges[$child[0]] ) )
                {
                    $text .= "<li{$highlightPart}>{$linkStart}{$data}{$linkEnd}\n";
                    $text .= $this->doChildren( $child[0], $level + 2, $levelLast );
                    $text .= str_repeat( '  ', $level + 2 );
                    $text .= "</li>\n";
                }
                else
                {
                    $text .= "<li{$highlightPart}>{$linkStart}{$data}{$linkEnd}</li>\n";
                }
            }
            $text .= str_repeat( '  ', $level + 1);
            $text .= "</ul>\n";
        }

        return $text;
    }

    /**
     * Returns a text representatation of a tree.
     *
     * @return string
     * @ignore
     */
    public function __toString()
    {
        $tree = '';
        $this->treeIdSet = false;

        if ( $this->options->displayRootNode )
        {
            $idPart = $this->options->xmlId ? " id=\"{$this->options->xmlId}\"" : '';
            $tree .= "<ul{$idPart}>\n";
            $tree .= "<li>{$this->root}</li>\n";
            $this->treeIdSet = true;
        }
        $tree .= $this->doChildren( $this->root );
        if ( $this->options->displayRootNode )
        {
            $tree .= "</ul>\n";
        }
        return $tree;
    }
}
?>
