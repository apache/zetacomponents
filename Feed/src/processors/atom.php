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
 * Class providing parsing and generating of ATOM feeds.
 *
 * Specifications:
 * {@link http://atompub.org/rfc4287.html ATOM RFC4287}.
 *
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
     * Holds the definitions for the elements in RSS1.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected static $atomSchema = array(
        'id'            => array( '#'          => 'string' ),
        'title'         => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string' ), ),

        'updated'       => array( '#'          => 'string' ),

        'author'        => array( '#'          => 'string' ),
        'link'          => array( '#'          => 'string' ),
        'category'      => array( '#'          => 'string' ),
        'contributor'   => array( '#'          => 'none',
                                  'NODES'      => array(
                                                    'name' => 'string',
                                                    'email' => 'string',
                                                    'uri' => 'string',
                                                    ),

                                  'REQUIRED'   => array( 'name' ),
                                  'OPTIONAL'   => array( 'email', 'uri' ),

                                  'MULTI'      => 'contributors' ),

        'generator'     => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'uri' => 'string',
                                                         'version' => 'string' ), ),

        'icon'          => array( '#'          => 'string' ),
        'logo'          => array( '#'          => 'string' ),
        'rights'        => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string' ), ),

        'subtitle'      => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string' ), ),

        'REQUIRED'      => array( 'id', 'title', 'updated' ),
        'OPTIONAL'      => array( 'author', 'link', 'category',
                                  'contributor', 'generator', 'icon',
                                  'logo', 'rights', 'subtitle' ),

        'ELEMENTS_MAP'  => array( 'image' => 'logo',
                                  'copyright' => 'rights',
                                  'description' => 'subtitle',
                                  'item' => 'entry' ),
        );

    /**
     * Creates a new ATOM processor.
     */
    public function __construct()
    {
        $this->feedType = self::FEED_TYPE;
        $this->schema = new ezcFeedSchema( self::$atomSchema );
    }

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * @return string
     */
    public function generate()
    {
        $this->xml = new DOMDocument( '1.0', 'utf-8' );
        $this->xml->formatOutput = 1;
        $this->createRootElement( '2.0' );
        $this->generateRequired();
        $this->generateOptional();

        return $this->xml->saveXML();
    }

    /**
     * Creates a root node for the XML document being generated.
     *
     * @param string $version The RSS version for the root node
     * @ignore
     */
    protected function createRootElement( $version )
    {
        $rss = $this->xml->createElementNS( 'http://www.w3.org/2005/Atom', 'feed' );
        $this->channel = $rss;
        $this->root = $this->xml->appendChild( $rss );
    }

    /**
     * Adds the required feed elements to the XML document being generated.
     *
     * @ignore
     */
    protected function generateRequired()
    {
        foreach ( $this->schema->getRequired() as $element )
        {
            $data = $this->schema->isMulti( $element ) ? $this->get( $this->schema->getMulti( $element ) ) : $this->get( $element );
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( $element );
            }

            if ( !is_array( $data ) )
            {
                $data = array( $data );
            }

            foreach ( $data as $dataNode )
            {
                switch ( $element )
                {
                    case 'updated':
                        // Sample date: 2003-12-13T18:30:02-05:00
                        $dataNode->set( date( "c", (int)$dataNode->get() ) );
                        break;
                }
                $this->generateNode( $this->channel, $element, $dataNode );

            }
        }
    }

    /**
     * Adds the optional feed elements to the XML document being generated.
     *
     * @ignore
     */
    protected function generateOptional()
    {
        foreach ( $this->schema->getOptional() as $element )
        {
            $data = $this->schema->isMulti( $element ) ? $this->get( $this->schema->getMulti( $element ) ) : $this->get( $element );

            if ( !is_null( $data ) )
            {
                if ( !is_array( $data ) )
                {
                    $data = array( $data );
                }

                foreach ( $data as $dataNode )
                {
                    $this->generateNode( $this->channel, $element, $dataNode );

                }
            }
        }
    }

    /**
     * Creates an XML node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the node to create
     * @param array(string=>mixed) $dataNode The data for the node to create
     * @ignore
     */
    protected function generateNode( DOMNode $root, $element, $dataNode )
    {
        $elementTag = $this->xml->createElement( $element );
        $root->appendChild( $elementTag );

        $attributes = array();
        foreach ( $this->schema->getAttributes( $element ) as $attribute => $type )
        {
            if ( isset( $dataNode->$attribute ) )
            {
                $val = $dataNode->$attribute;
                if ( $attribute === 'type' )
                {
                    switch ( $val )
                    {
                        case 'html':
                            $dataNode->set( htmlspecialchars( $dataNode ) );
                            $this->addAttribute( $elementTag, 'type', $val );
                            break;

                        case 'xhtml':
                            $this->addAttribute( $elementTag, 'type', $val );
                            $this->addAttribute( $elementTag, 'xmlns:xhtml', 'http://www.w3.org/1999/xhtml' );
                            $xhtmlTag = $this->xml->createElement( 'xhtml:div', $dataNode->__toString() );
                            $elementTag->appendChild( $xhtmlTag );
                            $elementTag = $xhtmlTag;
                            break;

                        case 'text':
                            // same as the default case

                        default:
                            $val = 'text';
                            $this->addAttribute( $elementTag, 'type', $val );
                            break;

                    }
                }
            }
        }

        $elementTag->nodeValue = $dataNode;
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
        if ( $xml->documentElement->tagName !== 'feed' )
        {
            return false;
        }

        return true;
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
        $feed = new ezcFeed( self::FEED_TYPE );
        $channel = $xml->documentElement;

        $this->usedPrefixes = array();
        $xp = new DOMXpath( $xml );
        $set = $xp->query( './namespace::*', $xml->documentElement );
        $this->usedNamespaces = array();

        foreach ( $channel->childNodes as $channelChild )
        {
            if ( $channelChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $channelChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getElementsMap() );

                switch ( $tagName )
                {
                    case 'title':
                        $type = ezcFeedTools::getAttribute( $channelChild, 'type' );

                        switch ( $type )
                        {
                            case 'xhtml':
                                $nodes = $channelChild->childNodes;
                                if ( $nodes instanceof DOMNodeList )
                                {
                                    $contentNode = $nodes->item( 1 );
                                    $feed->$tagName = $contentNode->nodeValue;
                                }
                                break;

                            case 'html':
                                $feed->$tagName = $channelChild->textContent;
                                break;

                            case 'text':
                                // same case as 'default'

                            default:
                                $feed->$tagName = $channelChild->textContent;
                                break;
                        }

                        break;

                    case 'id':
                        $feed->$tagName = $channelChild->textContent;
                        break;

                    default:
                        // check if it's part of a known module/namespace
                }
            }

            foreach ( ezcFeedTools::getAttributes( $channelChild ) as $key => $value )
            {
                if ( in_array( $tagName, array( 'category' ) ) )
                {
                    $element->$key = $value;
                }
                else
                {
                    $feed->$tagName->$key = $value;
                }
            }
        }

        return $feed;
    }

    /**
     * Parses the provided XML element object and stores it as a feed item in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed item
     * @param ezcFeedElement $element The feed element object that will contain the feed item
     * @param DOMElement $xml The XML element object to parse
     * @ignore
     */
    protected function parseItem( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
    }

    /**
     * Parses the provided XML element object and stores it as a feed image in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed image
     * @param DOMElement $xml The XML element object to parse
     * @ignore
     */
    protected function parseImage( ezcFeed $feed, DOMElement $xml )
    {
    }
}
?>
