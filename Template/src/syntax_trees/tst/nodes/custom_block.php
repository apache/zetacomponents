<?php
/**
 * File containing the ezcTemplateCustomBlockTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Custom block elements in parser trees.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCustomBlockTstNode extends ezcTemplateBlockTstNode
{
    /**
     * All parameters of the custom block as an associative array.
     * The key is the parameter name and the value is another element object.
     *
     * @var array
     */
    public $customParameters;

    /**
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->customParameters = array();
    }

    public function getTreeProperties()
    {
        return array( 'name'             => $this->name,
                      'isClosingBlock'   => $this->isClosingBlock,
                      'isNestingBlock'   => $this->isNestingBlock,
                      'customParameters' => $this->customParameters,
                      'children'         => $this->children );
    }

    public function symbol()
    {
        return '{' . ( $this->isClosingBlock ? '/' : '' ) . 'custom:' . $this->name . '}';
    }

    /**
     * Adds the element $parameter as a parameter of this custom block element.
     *
     * @param string $parameterName The name of the parameter.
     * @param ezcTemplateTstNode $parameter The element object to use as parameter
     */
    public function appendParameter( $parameterName, ezcTemplateTstNode $nameElement, ezcTemplateTstNode $parameter )
    {
        $this->customParameters[$parameterName] = array( $nameElement,
                                                         $parameter );
    }

    /**
     * Checks if the parameter named $parameterName is set in the block and the result.
     *
     * @param string $parameterName The name of the parameter.
     * @return bool
     */
    public function hasParameter( $parameterName )
    {
        return isset( $this->customParameters[$parameterName] );
    }

    /**
     *
     * @retval ezcTemplateAstNode
     * @todo Not implemented yet.
     */
    public function transform(  )
    {
    }
}
?>
