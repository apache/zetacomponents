<?php
/**
 * File containing the ezcFeedAtom class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedAtom extends ezcFeedProcessor implements ezcFeedParser
{
    /**
     * Defines the feed type of this processor.
     */
    const FEED_TYPE = 'atom';

    /**
     * Holds a list of modules that are supported by this feed type.
     *
     * @var array(string)
     */
    protected $supportedModules = array();

    /**
     * Creates a new ATOM processor.
     */
    public function __construct()
    {
        $this->feedType = self::FEED_TYPE;
    }

    /**
     * Sets the value of the feed element $element to $value.
     *
     * The hook {@link ezcFeedProcessor::processModuleFeedSetHook()} is called
     * before setting $element.
     *
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    public function setFeedElement( $element, $value )
    {
    }

    /**
     * Returns the value of the feed element $element.
     *
     * @param string $element The feed element
     * @return mixed
     */
    public function getFeedElement( $element )
    {
    }

    /**
     * Sets the value of the feed element $element of feed item $item to $value.
     *
     * The hook {@link ezcFeedProcessor::processModuleItemSetHook()} is called
     * before setting $element.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    public function setFeedItemElement( ezcFeedItem $item, $element, $value )
    {
    }

    /**
     * Returns the value of the element $element of feed item $item.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @return mixed
     */
    public function getFeedItemElement( ezcFeedItem $item, $element )
    {
    }

    /**
     * Sets the value of the feed element $element of the feed image to $value.
     *
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    public function setFeedImageElement( $element, $value )
    {
    }

    /**
     * Returns the value of the element $element of the feed image.
     *
     * @param string $element The feed element
     * @return mixed
     */
    public function getFeedImageElement( $element )
    {
    }

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * The hooks {@link ezcFeedProcessor::processModuleFeedGenerateHook()} and
     * {@link ezcFeedProcessor::processModuleItemGenerateHook()} are used for
     * each attribute in the feed and in the feed items.
     *
     * @return string
     */
    public function generate()
    {
    }

    /**
     * Returns true if the parser can parse the provided XML document object,
     * false otherwise.
     *
     * @param DOMDocument $xml The XML document object to check for parseability
     * @return bool
     */
    public static function canParse( DOMDocument $xml )
    {
        return false;
    }

    /**
     * Parses the provided XML document object and returns an ezcFeed object
     * from it.
     *
     * @throws ezcFeedParseErrorException
     *         If an error was encountered during parsing.
     *
     * @param DOMDocument $xml The XML document object to parse
     * @return ezcFeed
     */
    public function parse( DOMDocument $xml )
    {
    }

    /**
     * Parses the provided XML element object and stores it as a feed item in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed item
     * @param DOMElement $xml The XML element object to parse
     */
    public function parseItem( ezcFeed $feed, DOMElement $item )
    {
    }

    /**
     * Parses the provided XML element object and stores it as a feed image in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed image
     * @param DOMElement $xml The XML element object to parse
     */
    public function parseImage( ezcFeed $feed, DOMElement $xml )
    {
    }
}
?>
