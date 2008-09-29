<?php
/**
 * File containing the ezcDocumentWikiLinkStartToken struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document link start marker tokens
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiConfluenceLinkStartToken extends ezcDocumentWikiLinkStartToken
{
    /**
     * Get link parameter order
     * 
     * Links may have any amount of parameters and the order may not be the
     * same for each amount. This method should return an ordered list of
     * parameter names for the given amount of parameters.
     *
     * @param int $count 
     * @return array
     */
    public function getLinkParameterOrder( $count )
    {
        if ( $count === 1 )
        {
            return array( 'link' );
        }

        return array_slice(
            array(
                'title',
                'link',
                'description',
            ),
            0, $count
        );
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
        $tokenClass = __CLASS__;
        $token = new $tokenClass(
            $properties['content'],
            $properties['line'],
            $properties['position']
        );

        // Set additional token values
        // $token->value = $properties['value'];

        return $token;
    }
}

?>
