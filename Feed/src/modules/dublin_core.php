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
class ezcFeedModuleDublinCore extends ezcFeedModule
{
    private $feedType;
    protected $supportedElements = array(
        'title', 'creator', 'subject', 'description', 'publisher',
        'contributor', 'date', 'type', 'format', 'identifier',
        'source', 'language', 'relation', 'coverage', 'rights'
    );

    public function __construct( $feedType )
    {
        $this->feedType = $feedType;
    }

    public function getNamespace()
    {
        return 'http://purl.org/dc/elements/1.1/';
    }

    public function getNamespacePrefix()
    {
        return 'dc';
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
                $feedProcessor->generateMetaData( "$prefix:$element", date( DATE_ISO8601, $value ) );
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
                $feedProcessor->generateItemData( $itemTag, "$prefix:$element", date( DATE_ISO8601, $value ) );
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

    public function feedMetaHook( $element, $value )
    {
        if ( in_array( $this->feedType, array( 'rss1' ) ) )
        {
            return array( $element, $value );
        }
        return NULL;
    }
}
?>
