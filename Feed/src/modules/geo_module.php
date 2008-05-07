<?php
/**
 * File containing the ezcFeedGeoModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Support for the Geo module: data container, generator, parser.
 *
 * Specifications: {@link http://www.w3.org/2003/01/geo/}.
 *
 * Create example:
 * <code>
 * // $feed is an ezcFeed object
 * $item = $feed->add( 'item' );
 * $module = $item->addModule( 'Geo' );
 * $module->alt = 1000;
 * $module->lat = 26.58;
 * $module->long = -97.83;
 * </code>
 *
 * Parse example:
 * <code>
 * // $item is an ezcFeedItem object
 * $alt = isset( $item->Geo->alt ) ? $item->Geo->alt[0] : null;
 * $lat = isset( $item->Geo->lat ) ? $item->Geo->lat[0] : null;
 * $long = isset( $item->Geo->long ) ? $item->Geo->long[0] : null;
 * </code>
 *
 * @property ezcFeedElement $alt
 *                          Altitude in decimal meters above the local
 *                          reference ellipsoid (eg. 509.2). Can also be
 *                          negative.
 * @property ezcFeedElement $lat
 *                          {@link http://en.wikipedia.org/wiki/WGS84 WGS84} latitude
 *                          on the globe as decimal degrees
 *                          (eg. 25.03358300). Can also be negative.
 * @property ezcFeedElement $long
 *                          {@link http://en.wikipedia.org/wiki/WGS84 WGS84} longitude
 *                          on the globe as decimal degrees
 *                          (eg. 121.56430000). Can also be negative.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedGeoModule extends ezcFeedModule
{
    /**
     * Holds the schema for this feed module.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $schema = array(
        'feed' => array(),
        'item' => array( 'alt'  => array( '#' => 'string' ),
                         'lat'  => array( '#' => 'string' ),
                         'long' => array( '#' => 'string' ),
                         ) );

    /**
     * Constructs a new ezcFeedContentModule object.
     *
     * @param string $level The level of the data container ('feed' or 'item')
     */
    public function __construct( $level = 'feed' )
    {
        parent::__construct( $level );
    }

    /**
     * Adds the module elements to the $xml XML document, in the container $root.
     *
     * @param DOMDocument $xml The XML document in which to add the module elements
     * @param DOMNode $root The parent node which will contain the module elements
     */
    public function generate( DOMDocument $xml, DOMNode $root )
    {
        foreach ( $this->schema[$this->level] as $element => $schema )
        {
            if ( isset( $this->$element ) )
            {
                foreach ( $this->$element as $values )
                {
                    $elementTag = $xml->createElement( $this->getNamespacePrefix() . ':' . $element );
                    $root->appendChild( $elementTag );

                    switch ( $element )
                    {
                        case 'alt':
                        case 'lat':
                        case 'long':
                            $elementTag->nodeValue = $values->__toString();
                            break;
                    }
                }
            }
        }
    }

    /**
     * Parses the XML element $node and creates a feed element in the current
     * module with name $name.
     *
     * @param string $name The name of the element belonging to the module
     * @param DOMElement $node The XML child from which to take the values for $name
     */
    public function parse( $name, DOMElement $node )
    {
        if ( $this->isElementAllowed( $name ) )
        {
            $element = $this->add( $name );
            $value = $node->textContent;

            switch ( $name )
            {
                case 'alt':
                case 'lat':
                case 'long':
                    $element->set( $value );
                    break;
            }
        }
    }

    /**
     * Returns the module name (Geo').
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Geo';
    }

    /**
     * Returns the namespace for this module ('http://www.w3.org/2003/01/geo/wgs84_pos#').
     *
     * @return string
     */
    public static function getNamespace()
    {
        return 'http://www.w3.org/2003/01/geo/wgs84_pos#';
    }

    /**
     * Returns the namespace prefix for this module ('geo').
     *
     * @return string
     */
    public static function getNamespacePrefix()
    {
        return 'geo';
    }
}
?>
