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
 * Extended abstract class for representing PHP code elements which have parameters.
 *
 * The extended class adds a parameter list and has a method to return them
 * and append new ones. In addition it can control the minimum and maxium
 * number of parameters a class should have.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
abstract class ezcTemplateParameterizedAstNode extends ezcTemplateAstNode
{
    /**
     * A list of parameters for the code element.
     * The number of parameters and how they are treated is up to each specific
     * code element class.
     *
     * @var array
     */
    public $parameters;

    /**
     * Controls the minimum number of parameters the operator can handle.
     * @var int
     */
    public $minParameterCount;

    /**
     * Controls the maximum number of parameters the operator can handle.
     * @var int
     */
    public $maxParameterCount;

    /**
     * @param int $minParameterCount The minimum parameters the operator can have, set to false to remove limit.
     * @param int $maxParameterCount The maximum parameters the operator can have, set to false to remove limit.
     */
    public function __construct( $minParameterCount = 1, $maxParameterCount = 1 )
    {
        parent::__construct();
        if ( !is_int( $minParameterCount ) &&
             $minParameterCount !== false )
        {
            throw new Exception( "The parameter \$minParameterCount needs be an integer." );
        }

        if ( !is_int( $maxParameterCount ) &&
             $maxParameterCount !== false )
        {
            throw new Exception( "The parameter \$maxParameterCount needs be an integer." );
        }

        $this->minParameterCount = $minParameterCount;
        $this->maxParameterCount = $maxParameterCount;
        $this->parameters = array();
    }

    /**
     * Appends the code element $code as a parameter to the current code element.
     * @param ezcTemplateAstNode $code The code element to append.
     * @todo Fix exception class + doc for it
     */
    public function appendParameter( ezcTemplateAstNode $code )
    {
        if ( $this->maxParameterCount !== false &&
             count( $this->parameters ) >= $this->maxParameterCount )
            throw new Exception( "Parameter count {$this->maxParameterCount} exceeded." );

        $this->parameters[] = $code;

        if( $this->minParameterCount !== false && $this->minParameterCount == sizeof( $this->parameters ) )
        {
            $this->checkAndSetTypeHint();
        }
    }

       
    public function checkAndSetTypeHint()
    {
        $first = true;
        foreach( $this->parameters as $parameter )
        {
            if( $parameter->typeHint == null )
            {
                exit( "The typehint of the class ". get_class( $parameter ) . " is null" ); 
            }

            if( $first )
            {
                $this->typeHint = $parameter->typeHint;
                $first = false;
            }
            else
            {
                $this->typeHint &= $parameter->typeHint;

                if( !( $this->typeHint & self::TYPE_VALUE  ) )
                {
                    throw new Exception ("Typehint failure");
                }
            }
        }
    }


    /**
     * Returns the parameters of the code element.
     *
     * @note Not all code elements uses parameters.
     *
     * @return array(ezcTemplateAstNode)
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Validates the parameters of the operators against their constraints.
     *
     * @throw Exception if the constraints are not met.
     * @todo Fix exception class
     */
    public function validate()
    {
        if ( $this->maxParameterCount !== false &&
             count( $this->parameters ) > $this->maxParameterCount )
            throw new Exception( "Too many parameters for class <" . get_class( $this ) . ">, needs at most {$this->maxParameterCount} but got <" . count( $this->parameters ) . ">." );

        if ( $this->minParameterCount !== false &&
             count( $this->parameters ) < $this->minParameterCount )
            throw new Exception( "Too few parameters for class <" . get_class( $this ) . ">, needs at least {$this->minParameterCount} but got <" . count( $this->parameters ) . ">." );
    }
}
?>
