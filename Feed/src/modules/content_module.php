<?php
/**
 * File containing the ezcFeedContentModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Support for the Content module: data container, generator, parser.
 *
 * Specifications: {@link http://purl.org/rss/1.0/modules/content/}. Only support
 * for the 'encoded' element of the Content module is provided.
 *
 * Create example:
 * <code>
 * // $feed is an ezcFeed object
 * $item = $feed->add( 'item' );
 * $module = $item->addModule( 'Content' );
 * $module->encoded = 'text content';
 * </code>
 *
 * Parse example:
 * <code>
 * // $item is an ezcFeedItem object
 * $text = $item->Content->encoded;
 * </code>
 *
 * @property string $encoded
 *                  Item-level container for text. The text is stored in a feed by
 *                  applying htmlspecialchars() with ENT_NOQUOTES and restored from
 *                  a feed with htmlspecialchars_decode() with ENT_NOQUOTES.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedContentModule extends ezcFeedModule
{
    /**
     * Holds the schema for this feed module.
     *
     * @var array(string)
     */
    protected $schema = array(
        'feed' => array(),
        'item' => array( 'encoded' ) );

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
        foreach ( $this->schema[$this->level] as $element )
        {
            if ( isset( $this->$element ) )
            {
                $elementTag = $xml->createElement( $this->getNamespacePrefix() . ':' . $element );
                $root->appendChild( $elementTag );

                switch ( $element )
                {
                    case 'encoded':
                        $elementTag->nodeValue = htmlspecialchars( $this->$element, ENT_NOQUOTES );
                        break;
                }
            }
        }
    }

    /**
     * Parses the $value and returns a converted value if required based on $name.
     *
     * @param string $name The name of the element belonging to the module
     * @param mixed $value The value which needs to be converted
     * @return mixed
     */
    public function parse( $element, $value )
    {
        switch ( $element )
        {
            case 'encoded':
                return htmlspecialchars_decode( $value, ENT_NOQUOTES );

            default:
                return $value;
        }
    }

    /**
     * Returns the module name ('Content').
     *
     * @return string
     */
    public function getModuleName()
    {
        return 'Content';
    }

    /**
     * Returns the namespace for this module ('http://purl.org/rss/1.0/modules/content/').
     *
     * @return string
     */
    public function getNamespace()
    {
        return 'http://purl.org/rss/1.0/modules/content/';
    }

    /**
     * Returns the namespace prefix for this module ('content').
     *
     * @return string
     */
    public function getNamespacePrefix()
    {
        return 'content';
    }
}
?>
