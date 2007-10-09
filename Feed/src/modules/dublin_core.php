<?php
/**
 * File containing the ezcFeedModuleDublinCore class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class for handling a DublinCore feed module.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedModuleDublinCore implements ezcFeedModule
{
    /**
     * Holds the feed type of this module (eg. 'rss2').
     *
     * @var string
     */
    protected $feedType;

    /**
     * Holds the supported elements for this module.
     *
     * @var array(string)
     */
    protected $supportedElements = array(
        'title', 'creator', 'subject', 'description', 'publisher',
        'contributor', 'date', 'type', 'format', 'identifier',
        'source', 'language', 'relation', 'coverage', 'rights'
    );

    /**
     * Creates a new DublinCore module with the feed type as $feedType.
     *
     * @param string $feedType The feed type of the new module
     */
    public function __construct( $feedType )
    {
        $this->feedType = $feedType;
    }

    /**
     * Returns the module name ('DublinCore').
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'DublinCore';
    }

    /**
     * Returns the namespace for this module ('http://purl.org/dc/elements/1.1/').
     *
     * @return string
     */
    public static function getNamespace()
    {
        return 'http://purl.org/dc/elements/1.1/';
    }

    /**
     * Returns the namespace prefix for this module ('dc').
     *
     * @return string
     */
    public static function getNamespacePrefix()
    {
        return 'dc';
    }

    /**
     * Returns true if the name $element is allowed as a channel element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isChannelElementAllowed( $element )
    {
        return in_array( $element, $this->supportedElements );
    }

    /**
     * Returns true if the name $element is allowed as an item element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isItemElementAllowed( $element )
    {
        return in_array( $element, $this->supportedElements );
    }

    /**
     * Return true if setting the item $element to $value is allowed, false
     * otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedMetaSetHook( $element, $value )
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

    /**
     * Return true if setting the item $element to $value is allowed with the
     * module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) $moduleData The module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedMetaGenerateHook( $moduleData, $element, $value )
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

    /**
     * Return true if setting the item $element to $value is allowed, false
     * otherwise.
     *
     * It is a hook called before setting the item $element to $value.
     *
     * @param string $element The name of the item element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedItemSetHook( $element, $value )
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

    /**
     * Return true if setting the item $element to $value is allowed with the
     * item module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) $moduleData The item module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedItemGenerateHook( $moduleData, $element, $value )
    {
        if ( isset( $moduleData['date'] ) && $element === 'published' )
        {
            return false;
        }
        return true;
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
}
?>
