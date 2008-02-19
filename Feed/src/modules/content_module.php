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
 * @property ezcFeedElement $encoded
 *                          Item-level container for text. The text is stored
 *                          in a feed by applying htmlspecialchars() with
 *                          ENT_NOQUOTES and restored from a feed with
 *                          htmlspecialchars_decode() with ENT_NOQUOTES.
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
        'item' => array( 'encoded' => array( '#' => 'string' ),
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
                        case 'encoded':
                            $elementTag->nodeValue = htmlspecialchars( $values->__toString(), ENT_NOQUOTES );
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
    public function parse( $name, $node )
    {
        if ( $this->isElementAllowed( $name ) )
        {
            $element = $this->add( $name );
            $value = $node->textContent;

            switch ( $name )
            {
                case 'encoded':
                    $element->set( htmlspecialchars_decode( $value, ENT_NOQUOTES ) );
                    break;
            }
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
