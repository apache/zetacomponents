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
     * Checks if the visitor object is accepted and if so calls the appropriate
     * visitor method in it.
     *
     * The sub classes don't need to implement the usual accept() method.
     *
     * If the current object is: ezcTemplateVariableAstNode then
     * the method: $visitor->visitVariableTstNode( $this ) will be called.
     *
     * @param ezcTemplateBasicAstNodeVisitor $visitor
     *        The visitor object which can visit the current code element.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $class = get_class( $this );
        $visit = "visit" . substr( $class, 11 );

        return $visitor->$visit( $this );
    }
}
?>
