<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @access private
 */
/**
 * @package Feed
 * @version //autogentag//
 * @access private
 */
class ezcFeedModuleDublinCore implements ezcFeedModule
{
    private $feedType;
    private $supportedElements = array(
        'title', 'creator', 'subject', 'description', 'publisher',
        'contributor', 'date', 'type', 'format', 'identifier',
        'source', 'language', 'relation', 'coverage', 'rights'
    );

    public function __construct( $feedType )
    {
        $this->feedType = $feedType;
    }

    public static function getModuleName()
    {
        return 'DublinCore';
    }

    public static function getNamespace()
    {
        return 'http://purl.org/dc/elements/1.1/';
    }

    public static function getNamespacePrefix()
    {
        return 'dc';
    }

    public function isChannelElementAllowed( $element )
    {
        return in_array( $element, $this->supportedElements );
    }

    public function isItemElementAllowed( $element )
    {
        return in_array( $element, $this->supportedElements );
    }

    public function prepareDate( $date )
    {
        if ( is_int( $date ) || is_numeric( $date ) )
        {
            return $date;
        }
        $ts = strtotime( $date );
        if ( $ts !== false )
        {
            return $ts;
        }
        return time();
    }

    public function generateMetaData( $feedProcessor, $element, $value )
    {
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            case 'date':
                $feedProcessor->generateMetaData( "$prefix:$element", date( DATE_W3C, $value ) );
                break;
            default:
                $feedProcessor->generateMetaData( "$prefix:$element", $value );
                break;
        }
    }

    public function generateItemData( $itemTag, $feedProcessor, $element, $value )
    {
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            case 'date':
                $feedProcessor->generateItemData( $itemTag, "$prefix:$element", date( DATE_W3C, $value ) );
                break;
            default:
                $feedProcessor->generateItemData( $itemTag, "$prefix:$element", $value );
                break;
        }
    }
    
    public function prepareMetaData( $element, $value )
    {
        switch ( $element )
        {
            case 'date':
                $value = $this->prepareDate( $value );
                break;
        }
        return $value;
    }

    public function feedMetaSetHook( &$element, &$value )
    {
        if ( in_array( $this->feedType, array( 'rss1' ) ) )
        {
            return true;
        }
        if ( $element === 'published' )
        {
            return false;
        }
        return null;
    }

    public function feedMetaGenerateHook( $moduleData, &$element, &$value )
    {
        if ( 
            ( isset( $moduleData['creator'] ) && $element === 'author' ) ||
            ( isset( $moduleData['date'] ) && $element === 'published' )
        )
        {
            return false;
        }
        return true;
    }

    public function feedItemSetHook( &$element, &$value )
    {
        if ( in_array( $this->feedType, array( 'rss1' ) ) )
        {
            return true;
        }
        if ( $element === 'published' )
        {
            return false;
        }
        return null;
    }

    public function feedItemGenerateHook( $moduleData, &$element, &$value )
    {
        if ( isset( $moduleData['date'] ) && $element === 'published' )
        {
            return false;
        }
        return true;
    }
}
?>
