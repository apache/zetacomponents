<?php
/**
 * File containing the ezcTemplateDeclarationTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateDeclarationTstNode extends ezcTemplateBlockTstNode
{
    public $type;
    public $variable;

    public $expression;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->type = "normal";
        $this->variable = null;
        $this->expression = null;
    }

    public function getTreeProperties()
    {
        return array( 'type'       => $this->type,
                      'variable'   => $this->variable,
                      'expression' => $this->expression );
    }
}
?>
