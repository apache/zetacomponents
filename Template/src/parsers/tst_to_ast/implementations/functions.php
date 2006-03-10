<?php
/**
 * File containing the ezcTemplateFunctions class
 *
 * @package TemplateFunctions
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateFunctions
{
    protected $functionToClass;

    public function __construct()
    {
        $this->functionToClass = include( "function_to_class.php" );
    }

    protected static function functionCall( $name, $parameters )
    {
        return array( "ezcTemplateFunctionCallAstNode", array( $name, array( "array", $parameters ) ) );
    }

    protected static function value( $val )
    {
        return array( "ezcTemplateTypeAstNode", array( $val ) );
    }

    protected static function constant( $val )
    {
        return array( "ezcTemplateConstantAstNode", array( $val ) );
    }

    protected static function concat( $left, $right )
    {
        return array( "ezcTemplateConcatOperatorAstNode", array( $left, $right ) );
    }

    protected function createObject( $className, $functionParameters )
    {
        if( $className == "array" )
        {
            return $functionParameters;
        }

        return call_user_func_array(
            array( new ReflectionClass( $className ), 'newInstance' ), $functionParameters );
    }
 
    protected function processAst( $struct, $parameters )
    {
        $name = $struct[0];
        $params = $struct[1];

        $pOut = array();
        foreach( $params as $pIn )
        {
            if( is_array( $pIn ) )
            {
                $pOut[] = $this->processAst( $pIn, $parameters );
            }
            else
            {
                // Skip the optional parameter is the value is NULL.
                if( !($pIn[0] == "[" && $parameters[ $pIn ] === null ) )
                {
                    // If it starts with a percent or square bracket, then it is a parameter.
                    if( $pIn[0] == "%" || $pIn[0] == "[" )
                    {
                        $pOut[] = $parameters[ $pIn ];
                    }
                    else // Otherwise a hardcoded value.
                    {
                        $pOut[] = $pIn;
                    }
                }
            }
        }

        $ast = $this->createObject( $name, $pOut );

        return $ast;
    }

    protected function createAstNodes( $astStructure, $processedParameters )
    {
        /*
        if ( sizeof( $astStructure[0] ) != $templateParams )
        {
            // Throw exception, wrong amount of parameters?
            // Check the stuff between : "[ .. ] ".
        }
        */

        // For now, assume it's okay.
        $i = 0;
        foreach( $astStructure[0] as $p )
        {
            if( $p[0] == "[" && !isset( $processedParameters[$i] ) )
            {
                $parameters[ $p ] = null;
            }
            else
            {
                $parameters[ $p ] = $processedParameters[$i];
            }

            $i++;
        }

        $ast = $this->processAst( $astStructure[1], $parameters );

        return new ezcTemplateParenthesisAstNode( $ast );
    }

    public function getClass( $functionName )
    {
        foreach ($this->functionToClass as $func => $class )
        {
            if( preg_match( $func, $functionName ) )
            {
                return $class;
            }
            else
            {
                echo $func . "\n";
                echo $class . "\n"; 
            }
        }

        die ("Function not found!");
    }

    public function getAstTree( $functionName, $parameters )
    {
        $class = $this->getClass( $functionName );

           // The name is available in the hash.
            //$f = $class::getFunctionSubstitution( $functionName );
            $f = call_user_func( array( $class, "getFunctionSubstitution"), $functionName );

            if( $f !== null ) return $this->createAstNodes( $f, $parameters );

            // Try to find a manual function.

            // Return the AST nodes.
            //return $this->createAstNodes( $f, $parameters );

/*        
            // Reorder parameters if needed.
            $params = $this->fixParameters( $parameters, $f[1], isset( $f[2] ) ? $f[2] : null );
*/

        die ("Function not found");
    }




}
?>
