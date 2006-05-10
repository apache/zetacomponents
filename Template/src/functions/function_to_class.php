<?php
/**
 * File containing a mapping from functions to classes.
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
return array
( 

"/^str_.*/" => "ezcTemplateStringFunctions",
"/^array_.*/" => "ezcTemplateArrayFunctions",
"/^hash_.*/" => "ezcTemplateArrayFunctions",
"/^preg_.*/" => "ezcTemplateRegExpFunctions",
"/^preg_.*/" => "ezcTemplateRegExpFunctions",
"/^is_.*/"   => "ezcTemplateTypeFunctions",
"/^get_constant$/"   => "ezcTemplateTypeFunctions",
"/^cast_.*/" => "ezcTemplateTypeFunctions",
"/^math_.*/" => "ezcTemplateMathFunctions",
"/^debug_.*/" => "ezcTemplateDebugFunctions",
);


?>
