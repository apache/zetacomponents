<?php
/**
 * File containing the ezcFeedCreativeCommonsModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Support for the CreativeCommons module: data container, generator, parser.
 *
 * Specifications: {@link http://backend.userland.com/creativeCommonsRssModule}.
 *
 * Create example:
 * <code>
 * // $feed is an ezcFeed object
 * $item = $feed->add( 'item' );
 * $module = $item->addModule( 'CreativeCommons' );
 * $module->license = 'text content';
 * </code>
 *
 * Parse example:
 * <code>
 * // $item is an ezcFeedItem object
 * $text = $item->CreativeCommons->license;
 * </code>
 *
 * @property ezcFeedElement $license
 *                          An URL to a license description. Can appear at both
 *                          feed-level and item-level. A list of possible licenses
 *                          are found here {@link http://creativecommons.org/licenses/},
 *                          but other licenses can be used as well.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedCreativeCommonsModule extends ezcFeedModule
{
    /**
     * Holds the schema for this feed module.
     *
     * @var array(string)
     * @ignore
     */
    protected $schema = array(
        'feed' => array( 'license' => array( '#' => 'string' ) ),
        'item' => array( 'license' => array( '#' => 'string' ) ) );

    /**
     * Constructs a new ezcFeedCreativeCommonsModule object.
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
                        case 'license':
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
                case 'license':
                    $element->set( $value );
                    break;
            }
        }
    }

    /**
     * Returns the module name ('CreativeCommons').
     *
     * @return string
     */
    public function getModuleName()
    {
        return 'CreativeCommons';
    }

    /**
     * Returns the namespace for this module ('http://backend.userland.com/creativeCommonsRssModule').
     *
     * @return string
     */
    public function getNamespace()
    {
        return 'http://backend.userland.com/creativeCommonsRssModule';
    }

    /**
     * Returns the namespace prefix for this module ('creativeCommons').
     *
     * @return string
     */
    public function getNamespacePrefix()
    {
        return 'creativeCommons';
    }
}
?>
