<?php
/**
 * File containing the ezcDocumentWikiImageStartToken struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document image tag open marker tokens
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiImageStartToken extends ezcDocumentWikiToken
{
    /**
     * Image width
     * 
     * @var int
     */
    public $width      = null;
                    
    /**
     * Image height
     * 
     * @var int
     */
    public $height     = null;
                    
    /**
     * Image alignement
     * 
     * @var string
     */
    public $alignement = null;

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $tokenClass = __CLASS__;
        $token = new $tokenClass(
            $properties['content'],
            $properties['line'],
            $properties['position']
        );

        // Set additional token values
        $token->width      = $properties['width'];
        $token->height     = $properties['height'];
        $token->alignement = $properties['alignement'];

        return $token;
    }
}

?>
