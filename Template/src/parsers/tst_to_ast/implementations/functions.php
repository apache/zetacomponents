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
    protected $functions;

    protected function functionCall( $name, $parameters )
    {
        return array( "ezcTemplateFunctionCallAstNode", array( $name, array( "array", $parameters ) ) );
    }

    protected function value( $val )
    {
        return array( "ezcTemplateTypeAstNode", array( $val ) );
    }

    protected function constant( $val )
    {
        return array( "ezcTemplateConstantAstNode", array( $val ) );
    }


    protected function concat( $left, $right )
    {
        return array( "ezcTemplateConcatOperatorAstNode", array( $left, $right ) );
    }

    public function __construct()
    {
        $this->functions = array
        (
            // str_replace( $sl, $index, $len, $sr )
            // substr( $sl, 0, $index ) . $sr . substr( $sl, $index + $len );
             "str_replace" => 
                array( array("%left", "%index", "%length", "%right"), 
                   self::concat( 
                       self::functionCall( "substr", array( "%left", self::value( 0 ), "%index" ) ),
                       self::concat( 
                           "%right", 
                           self::functionCall( 
                               "substr", 
                               array( "%left", array("ezcTemplateAdditionOperatorAstNode", array( "%index", "%length" ) ) ) 
                           ) 
                       ) 
                    )
                 ),
                                   
            // str_remove( $s, $index, $len ) 
            // substr( $s, 0, $index ) . substr( $s, $index + $len );
             "str_remove" => 
                array( array("%string", "%index", "%length"), 
                   self::concat( 
                       self::functionCall( "substr", array( "%string", self::value( 0 ), "%index" ) ),
                       self::functionCall( "substr", array( "%string", array("ezcTemplateAdditionOperatorAstNode", array( "%index", "%length" ) ) ) 
                           ) 
                        ) 
                     ),
  
            // string str_chop( $s, $len ) ( QString::chop ):
            // substr( $s, 0, strlen( $string ) - $len );
             "str_chop" => 
                array( array("%string", "%length"), 
                       self::functionCall( "substr", array( 
                           "%string", 
                           self::value( 0 ), 
                           array("ezcTemplateSubtractionOperatorAstNode", array(self::functionCall( "strlen", array( "%string" ) ), "%length" ) )
                       )
                   ) ),
                       
            // string str_chop_front( $s, $len )
            // substr( $s, $len );
             "str_chop_front" => array( array("%string", "%length"), self::functionCall( "substr", array( "%string", "%length" ) ) ),

             "str_append" => array( array("%left", "%right"), self::concat( "%left", "%right" ) ),

             "str_prepend" => array( array("%left", "%right"), self::concat( "%right", "%left" ) ),

            // str_compare( $sl, $sr )
            // strcmp( $sl, $sr );
            "str_compare" => array( array( "%left", "%right"), self::functionCall( "strcmp", array( "%left", "%right" ) ) ),

            // str_nat_compare( $sl, $sr )
            // strnatcmp( $sl, $sr );
            "str_nat_compare" => array( array( "%left", "%right"), self::functionCall( "strnatcmp", array( "%left", "%right" ) ) ),

            //str_contains( $sl, $sr ) ( QString::compare )::
            // strpos( $sl, $sr ) !== false 
            "str_contains" => array( array( "%left", "%right"), 
                array( "ezcTemplateNotIdenticalOperatorAstNode", 
                array( self::functionCall( "strpos", array( "%left", "%right" ) ), self::value( false ) ) ) ),

            // str_len( $s )
            // strlen( $s )
            "str_len" => array( array("%string"), self::functionCall( "strlen", array( "%string" ) ) ),

            // str_left( $s, $len )
            // substr( $s, 0, $len )
            "str_left" => array( array("%string", "%length"), self::functionCall( "substr", array( "%string", self::value(0), "%length" ) ) ),

            // str_starts_with( $sl, $sr )
            // strpos( $sl, $sr ) === 0
            "str_starts_with" => array( 
                array("%haystack", "%needle"), 
                array( "ezcTemplateIdenticalOperatorAstNode", array( 
                    self::functionCall( "strpos", array( "%haystack", "%needle" ) ),
                    self::value(0)
                ) ) ), 

            // str_right( $s, $len )
            // substr( $s, -$len )
            "str_right" => array( array("%string", "%length"), 
                self::functionCall( "substr", array( "%string", array( "ezcTemplateArithmeticNegationOperatorAstNode",  array("%length") ) ) ) ),

            // str_ends_with( $sl, $sr )
            // strrpos( $sl, $sr ) === ( strlen( $sl ) - strlen( $sr) )
            "str_ends_with" => array( 
                array("%haystack", "%needle"), 
                array( "ezcTemplateIdenticalOperatorAstNode", array( 
                    self::functionCall( "strrpos", array( "%haystack", "%needle" ) ),
                    array( "ezcTemplateSubtractionOperatorAstNode", array( 
                        self::functionCall( "strlen", array( "%haystack" ) ), 
                        self::functionCall( "strlen", array( "%needle" ) ) 
                    ) ) ) ) ), 

            // str_mid( $s, $index, $len )
            // substr( $s, $index, $len )
            "str_mid" => array( array("%string", "%index", "%length"), 
                self::functionCall( "substr", array( "%string", "%index", "%length") ) ),

            // str_at( $s, $index )
            // substr( $s, $index, 1 )
            "str_at" => array( array("%string", "%index"), 
                self::functionCall( "substr", array( "%string", "%index", self::value(1) ) ) ),

            // str_fill( $s, $len )
            // str_repeat( $s, $len )
            "str_fill" => array( array("%string", "%length"), 
                self::functionCall( "str_repeat", array( "%string", "%length" ) ) ),

            // str_index_of( $sl, $sr [, $index ] )
            // strpos( $sl, $sr [, $index ] )
            "str_index_of" => array( array("%haystack", "%needle", "[%index]"), 
                self::functionCall( "strpos", array( "%haystack", "%needle", "[%index]" ) ) ),
            
            // str_last_index( $sl, $sr [, $index] )
            // strrpos( $sl, $sr [, $index ] )
            "str_index_of" => array( array("%haystack", "%needle", "[%index]"), 
                self::functionCall( "strpos", array( "%haystack", "%needle", "[%index]" ) ) ),
             
            // str_is_empty( $s )
            // strlen( $s ) === 0
            "str_is_empty" => array( array("%string"), 
                array( "ezcTemplateIdenticalOperatorAstNode", array( 
                    self::functionCall( "strlen", array( "%string" ) ),
                    self::value( 0 ) ) ) ),
             
            // str_pad_left( $s, $len, $fill )
            // str_pad( $s, $len, $fill, STR_PAD_LEFT )
            "str_pad_left" => array( array("%string", "%length", "%fill"), 
                    self::functionCall( "str_pad", array( "%string", "%length", "%fill", self::constant( "STR_PAD_LEFT" ) ) ) ),
             
            // str_pad_right( $s, $len, $fill ) ( QString::rightJustified() )::
            // str_pad( $s, $len, $fill, STR_PAD_RIGHT )
            "str_pad_right" => array( array("%string", "%length", "%fill"), 
                    self::functionCall( "str_pad", array( "%string", "%length", "%fill", self::constant( "STR_PAD_RIGHT" ) ) ) ),
             
            // str_number( $num, $decimals, $point, $sep )
            // number_format( $num, $decimals, $point, $sep )
            "str_number" => array( array("%number", "%decimals", "%point", "%separator"), 
                    self::functionCall( "number_format", array( "%number", "%decimals", "%point", "%separator") ) ),
             
            // str_trimmed( $s [, $chars ] )
            // trim( $s [, $chars] )
            "str_trimmed" => array( array("%string", "[%chars]"), 
                    self::functionCall( "trim", array( "%string", "[%chars]") ) ),
             
            // str_trimmed_left( $s [, $chars] )
            // ltrim( $s [, $chars] )
            "str_trimmed_left" => array( array("%string", "[%chars]"), 
                    self::functionCall( "ltrim", array( "%string", "[%chars]") ) ),
             
            // str_trimmed_right( $s [, $chars] )
            // rtrim( $s, [$chars] )
            "str_trimmed_right" => array( array("%string", "[%chars]"), 
                    self::functionCall( "rtrim", array( "%string", "[%chars]") ) ),
             
            // str_simplified( $s )
            // trim( preg_replace( "/(\n|\t|\r\n|\s)+/", " ", $s ) )
            "str_simplified" => array( array("%string"), 
                    self::functionCall( "trim", array(
                        self::functionCall( "preg_replace", array( self::constant('"/(\n|\t|\r\n|\s)+/"'), self::value(" "), "%string") )
                    ) ) ),
             
            // str_split( $s, $sep[, $max] )
            // explode( $s, $sep, $max )
            "str_split" => array( array("%string", "%separator", "[%max]"), 
                    self::functionCall( "explode", array( "%separator", "%string", "[%max]") ) ),
             
            // str_join( $s_list, $sep ) ( QStringList::join )::
            // join( $sList, $sep )
            "str_join" => array( array("%list", "%separator"), 
                    self::functionCall( "join", array( "%separator", "%list") ) ),
             
            // str_printf( $format [...] ) ( QString::sprintf )::
            // sprintf( $format [...] )
            // TODO
             
            // str_chr( $ord1 [, $ord2...] )::
            // ord( $ord1 ) [ . ord( $ord2 ) ...]
            // TODO 
            
            // str_ord( $c )::
            // chr( $c )
            
            // str_ord_list( $s )::
            // chr( $s[0] ) [ . chr( $s[1] ) ]
            
            // str_upper( $s ) ( QString::toUpper )::
            // strtoupper( $s )
            
            // str_lower( $s ) ( QString::toLower )::
            // strtolower( $s )
            
            // str_capitalize( $s )::
            // ucfirst( $s )
            
            // str_find_replace( $s, $find, $replace, $count )::
            // str_replace( $s, $replace, $find, $count )
            
            // str_reverse( $s )::
            // strrev( $s )
            
            // str_section( $s, $sep, $start, $end = -1 ) ( QString::section )::
            // join( array_slice( split( $s, $sep, $end != -1 ? $end, false ), $start, $end ? $end : false ) )
            
            // str_char_count( $s )::
            // strlen( $s )
            
            // str_word_count( $s, $wordsep = false )::
            // str_word_count( $s, 0, $wordsep )
        );

    }


    protected function createObject( $className, $functionParameters)
    {
        if( $className == "array" )
        {
            return $functionParameters;
        }

        return call_user_func_array(
         array(new ReflectionClass($className), 'newInstance'), $functionParameters);
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
        //return new ezcTemplateFunctionCallAstNode( $newName, $parameters );
    }

    public function getAstTree( $functionName, $parameters )
    {
        if( isset( $this->functions[ $functionName ] ) )
        {
            // The name is available in the hash.
            $f = $this->functions[ $functionName ];

            // Return the AST nodes.
            return $this->createAstNodes( $f, $parameters );

/*        
            // Reorder parameters if needed.
            $params = $this->fixParameters( $parameters, $f[1], isset( $f[2] ) ? $f[2] : null );
*/

        }

        die ("Function not found");
    }




}
?>
