<?php
/**
 * File containing the ezcTemplateArrayFetchOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Fetching of array value in an expression.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateArrayFetchOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * The source operand element which the fetch is executed on.
     *
     * @var ezcTemplateTstNode
     */
    public $sourceOperand;

    /**
     * List of array keys to lookup expressed as parser elements.
     *
     * @var array(ezcTemplateTstNode)
     */
    public $arrayKeys;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end,
                             11, 1, self::RIGHT_ASSOCIATIVE,
                             '[...]' );
        $this->sourceOperand = null;
        $this->arrayKeys = array();
    }

    public function getTreeProperties()
    {
        return array( 'symbol'         => $this->symbol,
                      'sourceOperand'  => $this->sourceOperand,
                      'arrayKeys'      => $this->arrayKeys );
    }

    public function appendParameter( $element )
    {
        if ( $this->sourceOperand === null )
            $this->sourceOperand = $element;
        else
            $this->arrayKeys[] = $element;
        $this->parameters = array_merge( array( $this->sourceOperand ),
                                         $this->arrayKeys );
    }
}
?>
