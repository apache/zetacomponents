<?php
/**
 * File containing the ezcDocumentRstParagraphNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The inline markup AST node for strong emphasis markup
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstMarkupStrongEmphasisNode extends ezcDocumentRstMarkupNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token
     * @param bool $open
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, $open )
    {
        parent::__construct( $token, self::MARKUP_STRONG );
        $this->openTag = (bool) $open;
    }

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $node = new ezcDocumentRstMarkupStrongEmphasisNode(
            $properties['token'],
            $properties['openTag']
        );

        $node->nodes = $properties['nodes'];
        return $node;
    }
}

?>
