<?php
/**
 * File containing the ezcTemplateWeb class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateWeb
{
    public static function url_build( $data )
    {
        $url = '';
        if ( $data['scheme'] && $data['host'] )
        {
            $url .= $data['scheme'] . '://';
            if ( isset( $data['user'] ) )
            {
                $url .= $data['user'];
                if ( isset( $data['pass'] ) )
                {
                    $url .= ':' . $data['pass'];
                };
                $url .= '@';
            }
            $url .= $data['host'];
            if ( isset( $data['port'] ) )
            {
                $url .= ':' . $data['port'];
            }
        }
        $url .= $data['path'];
        if ( isset( $data['query'] ) )
        {
            $url .= '?' . $data['query'];
        }
        if ( isset( $data['fragment'] ) ) 
        {
            $url .= '#' . $data['fragment'];
        }

        return $url;
    }

}

?>
