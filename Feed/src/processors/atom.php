<?php
/**
 * File containing the ezcFeedAtom class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
     * Defines the feed content type of this processor.
     */
    const CONTENT_TYPE = 'application/atom+xml';

    /**
     * Holds the definitions for the elements in ATOM.
     *
     * @var array(string=>mixed)
     */
    private static $atomSchema = array(
        'id'            => array( '#'          => 'string' ),
        'title'         => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string',
                                                         'language' => 'string' ), ),

        'updated'       => array( '#'          => 'string' ),

        'author'        => array( '#'          => 'none',
                                  'NODES'      => array(
                                                    'name' => array( '#' => 'string' ),
                                                    'email' => array( '#' => 'string' ),
                                                    'uri' => array( '#' => 'string' ),

                                                    'REQUIRED'   => array( 'name' ),
                                                    'OPTIONAL'   => array( 'email', 'uri' ),
                                                    ),

                                  'MULTI'      => 'authors' ),

        'link'          => array( '#'          => 'none',
                                  'ATTRIBUTES' => array( 'href' => 'string',
                                                         'rel' => 'string',
                                                         'type' => 'string',
                                                         'hreflang' => 'string',
                                                         'title' => 'string',
                                                         'length' => 'string' ),

                                  'REQUIRED_ATTRIBUTES' => array( 'href' ),

                                  'MULTI'      => 'links' ),

        'category'      => array( '#'          => 'none',
                                  'ATTRIBUTES' => array( 'term' => 'string',
                                                         'scheme' => 'string',
                                                         'label' => 'string' ),

                                  'REQUIRED_ATTRIBUTES'   => array( 'term' ),

                                  'MULTI'      => 'categories' ),

        'contributor'   => array( '#'          => 'none',
                                  'NODES'      => array(
                                                    'name' => array( '#' => 'string' ),
                                                    'email' => array( '#' => 'string' ),
                                                    'uri' => array( '#' => 'string' ),

                                                    'REQUIRED'   => array( 'name' ),
                                                    'OPTIONAL'   => array( 'email', 'uri' ),
                                                    ),

                                  'MULTI'      => 'contributors' ),

        'generator'     => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'uri' => 'string',
                                                         'version' => 'string' ), ),

        'icon'          => array( '#'          => 'string' ),
        'logo'          => array( '#'          => 'string' ),
        'rights'        => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string',
                                                         'language' => 'string' ), ),

        'subtitle'      => array( '#'          => 'string',
                                  'ATTRIBUTES' => array( 'type' => 'string',
                                                         'language' => 'string' ), ),

        'entry'         => array( '#'          => 'none',
                                  'NODES'      => array(
                                                    'id'          => array( '#' => 'string' ),
                                                    'title'       => array( '#' => 'string',
                                                                            'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                   'language' => 'string' ), ),

                                                    'updated'     => array( '#' => 'string' ),

                                                    'author'      => array( '#' => 'none',
                                                                            'NODES'      => array(
                                                                                              'name' => array( '#' => 'string' ),
                                                                                              'email' => array( '#' => 'string' ),
                                                                                              'uri' => array( '#' => 'string' ),

                                                                                              'REQUIRED'   => array( 'name' ),
                                                                                              'OPTIONAL'   => array( 'email', 'uri' ),
                                                                                              ),

                                                                            'MULTI'      => 'authors' ),

                                                    'content'     => array( '#' => 'string',
                                                                            'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                   'src' => 'string',
                                                                                                   'language' => 'string' ), ),

                                                    'link'        => array( '#'          => 'none',
                                                                            'ATTRIBUTES' => array( 'href' => 'string',
                                                                                                   'rel' => 'string',
                                                                                                   'type' => 'string',
                                                                                                   'hreflang' => 'string',
                                                                                                   'title' => 'string',
                                                                                                   'length' => 'string' ),

                                                                            'REQUIRED_ATTRIBUTES' => array( 'href' ),

                                                                            'MULTI'      => 'links' ),

                                                    'summary'     => array( '#' => 'string',
                                                                            'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                   'language' => 'string' ), ),

                                                    'category'    => array( '#' => 'none',
                                                                            'ATTRIBUTES' => array( 'term' => 'string',
                                                                                                   'scheme' => 'string',
                                                                                                   'label' => 'string' ),

                                                                            'REQUIRED_ATTRIBUTES'   => array( 'term' ),

                                                                            'MULTI'      => 'categories' ),

                                                    'contributor' => array( '#' => 'none',
                                                                            'NODES'      => array(
                                                                                              'name' => array( '#' => 'string' ),
                                                                                              'email' => array( '#' => 'string' ),
                                                                                              'uri' => array( '#' => 'string' ),

                                                                                              'REQUIRED'   => array( 'name' ),
                                                                                              'OPTIONAL'   => array( 'email', 'uri' ),
                                                                                              ),

                                                                            'MULTI'      => 'contributors' ),

                                                    'published'   => array( '#'          => 'string' ),

                                                    'source'      => array( '#'          => 'none',
                                                                            'NODES'      => array(
                                                                                              'id'            => array( '#'          => 'string' ),
                                                                                              'title'         => array( '#'          => 'string',
                                                                                                                        'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                                                               'language' => 'string' ), ),

                                                                                              'updated'       => array( '#'          => 'string' ),

                                                                                              'author'        => array( '#'          => 'none',
                                                                                                                        'NODES'      => array(
                                                                                                                                          'name' => array( '#' => 'string' ),
                                                                                                                                          'email' => array( '#' => 'string' ),
                                                                                                                                          'uri' => array( '#' => 'string' ),

                                                                                                                                          'REQUIRED'   => array( 'name' ),
                                                                                                                                          'OPTIONAL'   => array( 'email', 'uri' ),
                                                                                                                                          ),

                                                                                                                        'MULTI'      => 'authors' ),

                                                                                              'link'          => array( '#'          => 'none',
                                                                                                                        'ATTRIBUTES' => array( 'href' => 'string',
                                                                                                                                               'rel' => 'string',
                                                                                                                                               'type' => 'string',
                                                                                                                                               'hreflang' => 'string',
                                                                                                                                               'title' => 'string',
                                                                                                                                               'length' => 'string' ),

                                                                                                                        'REQUIRED_ATTRIBUTES' => array( 'href' ),

                                                                                                                        'MULTI'      => 'links' ),

                                                                                              'category'      => array( '#'          => 'none',
                                                                                                                        'ATTRIBUTES' => array( 'term' => 'string',
                                                                                                                                               'scheme' => 'string',
                                                                                                                                               'label' => 'string' ),

                                                                                                                        'REQUIRED_ATTRIBUTES'   => array( 'term' ),

                                                                                                                        'MULTI'      => 'categories' ),

                                                                                              'contributor'   => array( '#'          => 'none',
                                                                                                                        'NODES'      => array(
                                                                                                                                          'name' => array( '#' => 'string' ),
                                                                                                                                          'email' => array( '#' => 'string' ),
                                                                                                                                          'uri' => array( '#' => 'string' ),

                                                                                                                                          'REQUIRED'   => array( 'name' ),
                                                                                                                                          'OPTIONAL'   => array( 'email', 'uri' ),
                                                                                                                                          ),

                                                                                                                        'MULTI'      => 'contributors' ),

                                                                                              'generator'     => array( '#'          => 'string',
                                                                                                                        'ATTRIBUTES' => array( 'uri' => 'string',
                                                                                                                                               'version' => 'string' ), ),

                                                                                              'icon'          => array( '#'          => 'string' ),
                                                                                              'logo'          => array( '#'          => 'string' ),
                                                                                              'rights'        => array( '#'          => 'string',
                                                                                                                        'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                                                               'language' => 'string' ), ),

                                                                                              'subtitle'      => array( '#'          => 'string',
                                                                                                                        'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                                                               'language' => 'string' ), ),

                                                                                              'OPTIONAL'      => array( 'id', 'title', 'updated',
                                                                                                                        'author', 'link', 'category',
                                                                                                                        'contributor', 'generator', 'icon',
                                                                                                                        'logo', 'rights', 'subtitle' ),

                                                                                              ),

                                                                            'ITEMS_MAP' => array( 'image' => 'logo',
                                                                                                  'copyright' => 'rights',
                                                                                                  'description' => 'subtitle' ) ),

                                                    'rights'      => array( '#' => 'string',
                                                                            'ATTRIBUTES' => array( 'type' => 'string',
                                                                                                   'language' => 'string' ), ),

                                                    'REQUIRED'   => array( 'id', 'title', 'updated' ),

                                                    'OPTIONAL'   => array( 'author', 'content', 'link', 'summary',
                                                                           'category', 'contributor', 'published', 'rights',
                                                                           'source' ),

                                                    // Only if the feed does not contain 'author'
                                                    'AT_LEAST_ONE' => array( 'author' ),

                                                    ),

                                  'ITEMS_MAP'  => array( 'copyright' => 'rights',
                                                         'description' => 'summary' ),

                                  'MULTI'      => 'entries' ),

        'REQUIRED'      => array( 'id', 'title', 'updated' ),
        'OPTIONAL'      => array( 'author', 'link', 'category',
                                  'contributor', 'generator', 'icon',
                                  'logo', 'rights', 'subtitle' ),

        // Only if there is one entry which does not contain 'author'
        'AT_LEAST_ONE'  => array( 'author' ),

        'ELEMENTS_MAP'  => array( 'image' => 'logo',
                                  'copyright' => 'rights',
                                  'description' => 'subtitle',
                                  'item' => 'entry',
                                  'items' => 'entries' ),
        );

    /**
     * Creates a new ATOM processor.
     */
    public function __construct()
    {
        $this->feedType = self::FEED_TYPE;
        $this->contentType = self::CONTENT_TYPE;
        $this->schema = new ezcFeedSchema( self::$atomSchema );

        // set default values: generator
        $generator = $this->add( 'generator' );
        $generator->set( 'eZ Components Feed' );
        $generator->uri = ezcFeed::GENERATOR_URI;
        $generator->version = ( ezcFeed::GENERATOR_VERSION === '//auto' . 'gentag//' ) ? 'dev' : ezcFeed::GENERATOR_VERSION;
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
        $this->generateAtLeastOne();
        $this->generateOptional();
        $this->generateFeedModules( $this->channel );
        $this->generateItems();

        return $this->xml->saveXML();
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

        $this->usedPrefixes = $this->fetchUsedPrefixes( $xml );

        foreach ( $channel->childNodes as $channelChild )
        {
            if ( $channelChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $channelChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getElementsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'copyright':
                    case 'description':
                        $type = $channelChild->getAttribute( 'type' );

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
                    case 'generator':
                    case 'image':
                    case 'icon':
                        $feed->$tagName = $channelChild->textContent;
                        break;

                    case 'updated':
                        $feed->$tagName = ezcFeedTools::prepareDate( $channelChild->textContent );
                        break;

                    case 'category':
                    case 'link':
                        $element = $feed->add( $tagName );
                        break;

                    case 'contributor':
                    case 'author':
                        $element = $feed->add( $tagName );
                        $this->parsePerson( $feed, $element, $channelChild, $tagName );
                        break;

                    case 'item':
                        $element = $feed->add( $tagName );
                        $this->parseItem( $feed, $element, $channelChild );
                        break;

                    default:
                        // check if it's part of a known module/namespace
                        $this->parseModules( $feed, $channelChild, $tagName );

                        // continue 2 = ignore modules when getting attributes below
                        continue 2;
                }
            }

            if ( $channelChild->hasAttributes() )
            {
                foreach ( $channelChild->attributes as $attribute )
                {
                    if ( in_array( $tagName, array( 'category', 'link' ) ) )
                    {
                        $element->{$attribute->name} = $attribute->value;
                    }
                    else if ( $attribute->name === 'lang' )
                    {
                        $feed->$tagName->language = $attribute->value;
                    }
                    else
                    {
                        $feed->$tagName->{$attribute->name} = $attribute->value;
                    }
                }
            }
        }

        return $feed;
    }

    /**
     * Creates a root node for the XML document being generated.
     *
     * @param string $version The RSS version for the root node
     */
    private function createRootElement( $version )
    {
        $rss = $this->xml->createElementNS( 'http://www.w3.org/2005/Atom', 'feed' );
        $this->channel = $rss;
        $this->root = $this->xml->appendChild( $rss );
    }

    /**
     * Adds the required feed elements to the XML document being generated.
     */
    private function generateRequired()
    {
        foreach ( $this->schema->getRequired() as $element )
        {
            $data = $this->schema->isMulti( $element ) ? $this->get( $this->schema->getMulti( $element ) ) : $this->get( $element );
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/feed/{$element}" );
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
                        $dataNode->set( ezcFeedTools::prepareDate( $dataNode->getValue() )->format( 'c' ) );
                        break;
                }
                $this->generateNode( $this->channel, $element, null, $dataNode );

            }
        }
    }

    /**
     * Adds the at-least-one feed elements to the XML document being generated.
     */
    private function generateAtLeastOne()
    {
        $needToThrowException = false;
        $element = 'author';

        $data = $this->schema->isMulti( $element ) ? $this->get( $this->schema->getMulti( $element ) ) : $this->get( $element );

        if ( is_null( $data ) )
        {
            // add checks for entry/author
            $entries = $this->get( 'entries' );
            if ( $entries === null )
            {
                throw new ezcFeedAtLeastOneItemDataRequiredException( array( '/feed/author' ) );
            }

            foreach ( $entries as $entry )
            {
                $authors = $entry->author;
                if ( $authors === null )
                {
                    throw new ezcFeedAtLeastOneItemDataRequiredException( array( '/feed/entry/author' ) );
                }
            }

            throw new ezcFeedAtLeastOneItemDataRequiredException( array( '/feed/author' ) );
        }
    }

    /**
     * Adds the optional feed elements to the XML document being generated.
     */
    private function generateOptional()
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

                switch ( $element )
                {
                    case 'contributor':
                        foreach ( $this->get( 'contributors' ) as $person )
                        {
                            $this->generatePerson( $this->channel, $person, $element );
                        }
                        break;

                    case 'author':
                        foreach ( $this->get( 'authors' ) as $person )
                        {
                            $this->generatePerson( $this->channel, $person, $element );
                        }
                        break;

                    case 'link':
                        $unique = array();
                        foreach ( $data as $dataNode )
                        {
                            if ( ( isset( $dataNode->rel ) && $dataNode->rel === 'alternate' )
                                 && isset( $dataNode->type )
                                 && isset( $dataNode->hreflang ) )
                            {
                                foreach ( $unique as $obj )
                                {
                                    if ( $obj['type'] === $dataNode->type
                                         && $obj['hreflang'] === $dataNode->hreflang )
                                    {
                                        throw new ezcFeedOnlyOneValueAllowedException( '/feed/link@rel="alternate"' );
                                    }
                                }

                                $unique[] = array( 'type' => $dataNode->type,
                                                   'hreflang' => $dataNode->hreflang );

                            }

                            $this->generateNode( $this->channel, $element, null, $dataNode );
                        }
                        break;

                    default:
                        foreach ( $data as $dataNode )
                        {
                            $this->generateNode( $this->channel, $element, null, $dataNode );
                        }
                        break;
                }
            }
        }
    }

    /**
     * Creates an XML node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the node to create
     * @param string $parent The name of the parent node which contains the node $element
     * @param array(string=>mixed) $dataNode The data for the node to create
     */
    private function generateNode( DOMNode $root, $element, $parent = null, $dataNode )
    {
        $elementTag = $this->xml->createElement( $element );
        $root->appendChild( $elementTag );

        $subElement = $parent;

        if ( $parent !== null )
        {
            $subElement = $element;
            $element = $parent;
        }

        $parentNode = ( $root->nodeName === 'entry' ) ? '/feed' : '';

        $attributes = array();
        $required = $this->schema->getRequiredAttributes( $element, $subElement );

        foreach ( $this->schema->getAttributes( $element, $subElement ) as $attribute => $type )
        {
            if ( isset( $dataNode->$attribute ) )
            {
                $val = $dataNode->$attribute;
                if ( $attribute === 'type' && $element !== 'link' )
                {
                    switch ( $val )
                    {
                        case 'html':
                            $dataNode->set( htmlspecialchars( $dataNode->__toString() ) );
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
                else if ( $attribute === 'language' && $dataNode->language !== null )
                {
                    if ( $dataNode->type === 'xhtml' )
                    {
                        $this->addAttribute( $elementTag->parentNode, 'xml:lang', $dataNode->language );
                    }
                    else
                    {
                        $this->addAttribute( $elementTag, 'xml:lang', $dataNode->language );
                    }
                }
                else
                {
                    $this->addAttribute( $elementTag, $attribute, $val );
                }
            }
            else if ( in_array( $attribute, $required ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "{$parentNode}/{$root->nodeName}/{$element}/@{$attribute}" );
            }
        }

        if ( !$this->schema->isEmpty( $element, $subElement ) )
        {
            $elementTag->nodeValue = ( $dataNode instanceof ezcFeedElement ) ? $dataNode->__toString() : (string)$dataNode;
        }
    }

    /**
     * Creates an XML node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the node to create
     * @param string $parent The name of the parent node which contains the node $element
     * @param array(string=>mixed) $dataNode The data for the node to create
     */
    private function generateContentNode( DOMNode $root, $element, $parent = null, $dataNode )
    {
        $elementTag = $this->xml->createElement( $element );
        $root->appendChild( $elementTag );

        $subElement = $parent;

        if ( $parent !== null )
        {
            $subElement = $element;
            $element = $parent;
        }

        $attributes = array();
        $required = $this->schema->getRequiredAttributes( $element, $subElement );

        foreach ( $this->schema->getAttributes( $element, $subElement ) as $attribute => $type )
        {
            if ( isset( $dataNode->$attribute ) )
            {
                $val = $dataNode->$attribute;
                if ( $attribute === 'type' )
                {
                    switch ( $val )
                    {
                        case 'html':
                            $dataNode->set( htmlspecialchars( $dataNode->__toString() ) );
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
                            $this->addAttribute( $elementTag, 'type', $val );
                            break;

                        default:
                            if ( preg_match( '@[+/]xml$@', $type ) !== 0 )
                            {
                                // @todo: implement to assign the text in $dataNode as an XML node into $elementTag
                                $this->addAttribute( $elementTag, 'type', $val );
                            }
                            else if ( substr_compare( $val, 'text/', 0, 5, true ) === 0 )
                            {
                                $dataNode->set( htmlspecialchars( $dataNode->__toString() ) );
                                $this->addAttribute( $elementTag, 'type', $val );
                                break;
                            }
                            else if ( $val !== null )
                            {
                                // @todo: make 76 and "\n" options?
                                $dataNode->set( chunk_split( base64_encode( $dataNode->__toString() ), 76, "\n" ) );
                                $this->addAttribute( $elementTag, 'type', $val );
                            }
                            else
                            {
                                $val = 'text';
                                $this->addAttribute( $elementTag, 'type', $val );
                            }
                            break;

                    }
                }
                else if ( $attribute === 'language' && $dataNode->language !== null )
                {
                    if ( $dataNode->type === 'xhtml' )
                    {
                        $this->addAttribute( $elementTag->parentNode, 'xml:lang', $dataNode->language );
                    }
                    else
                    {
                        $this->addAttribute( $elementTag, 'xml:lang', $dataNode->language );
                    }
                }
                else
                {
                    $this->addAttribute( $elementTag, $attribute, $val );
                }
            }
            else if ( in_array( $attribute, $required ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$root->nodeName}/{$element}/{$attribute}" );
            }
        }

        if ( !$this->schema->isEmpty( $element, $subElement ) )
        {
            $elementTag->nodeValue = ( $dataNode instanceof ezcFeedElement) ? $dataNode->__toString() : (string)$dataNode;
        }
    }

    /**
     * Creates an XML person node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param ezcFeedElement $feedElement The person feed element (author, contributor)
     * @param string $element The name of the node to create
     */
    private function generatePerson( DOMNode $root, ezcFeedElement $feedElement, $element )
    {
        $elementTag = $this->xml->createElement( $element );
        $root->appendChild( $elementTag );
        $parentNode = ( $root->nodeName === 'entry' ) ? '/feed' : '';

        foreach ( $this->schema->getRequired( $element ) as $child )
        {
            $data = $this->schema->isMulti( $element, $child ) ? $this->get( $this->schema->getMulti( $element, $child ) ) : $feedElement->$child;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "{$parentNode}/{$root->nodeName}/{$element}/{$child}" );
            }

            $this->generateMetaData( $elementTag, $child, $data );
        }

        foreach ( $this->schema->getOptional( $element ) as $child )
        {
            $data = $this->schema->isMulti( $element, $child ) ? $this->get( $this->schema->getMulti( $element, $child ) ) : $feedElement->$child;
            if ( !is_null( $data ) )
            {
                $this->generateMetaData( $elementTag, $child, $data );
            }
        }
    }

    /**
     * Creates an XML source node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the source node
     * @param ezcFeedElement $feedElement The person feed source
     */
    private function generateSource( DOMNode $root, ezcFeedElement $feedElement )
    {
        $element = 'source';
        $parent = 'entry';
        $elementTag = $this->xml->createElement( $element );
        $root->appendChild( $elementTag );

        foreach ( $this->schema->getOptional( $parent, $element ) as $child )
        {
            $data = $feedElement->$child;

            if ( !is_null( $data ) )
            {
                if ( !is_array( $data ) )
                {
                    $data = array( $data );
                }

                foreach ( $data as $dataNode )
                {
                    $childTag = $this->xml->createElement( $child );
                    $elementTag->appendChild( $childTag );

                    $attributes = array();
                    $required = $this->schema->getRequiredAttributes( $parent, $element, $child );

                    foreach ( $this->schema->getRequired( $parent, $element, $child ) as $attribute )
                    {
                        $val = $dataNode->$attribute;
                        if ( is_null( $val ) )
                        {
                            throw new ezcFeedRequiredMetaDataMissingException( "/feed/{$parent}/{$element}/{$child}/{$attribute}" );
                        }

                        $this->generateMetaData( $childTag, $attribute, $val );
                    }

                    foreach ( $this->schema->getOptional( $parent, $element, $child ) as $attribute )
                    {
                        $val = $dataNode->$attribute;
                        if ( !is_null( $val ) )
                        {
                            $this->generateMetaData( $childTag, $attribute, $val );
                        }
                    }

                    foreach ( $this->schema->getAttributes( $parent, $element, $child ) as $attribute => $type )
                    {
                        if ( isset( $dataNode->$attribute ) )
                        {
                            $val = $dataNode->$attribute;
                            if ( $attribute === 'type' && $child !== 'link' )
                            {
                                switch ( $val )
                                {
                                    case 'html':
                                        $dataNode->set( htmlspecialchars( $dataNode->__toString() ) );
                                        $this->addAttribute( $childTag, 'type', $val );
                                        break;

                                    case 'xhtml':
                                        $this->addAttribute( $childTag, 'type', $val );
                                        $this->addAttribute( $childTag, 'xmlns:xhtml', 'http://www.w3.org/1999/xhtml' );
                                        $xhtmlTag = $this->xml->createElement( 'xhtml:div', $dataNode->__toString() );
                                        $childTag->appendChild( $xhtmlTag );
                                        $childTag = $xhtmlTag;
                                        break;

                                    case 'text':
                                        // same as the default case

                                    default:
                                        $val = 'text';
                                        $this->addAttribute( $childTag, 'type', $val );
                                        break;

                                }
                            }
                            else if ( $attribute === 'language' && $dataNode->language !== null )
                            {
                                if ( $dataNode->type === 'xhtml' )
                                {
                                    $this->addAttribute( $childTag->parentNode, 'xml:lang', $dataNode->language );
                                }
                                else
                                {
                                    $this->addAttribute( $childTag, 'xml:lang', $dataNode->language );
                                }
                            }
                            else
                            {
                                $this->addAttribute( $childTag, $attribute, $val );
                            }
                        }
                        else if ( in_array( $attribute, $required ) )
                        {
                            throw new ezcFeedRequiredMetaDataMissingException( "/feed/{$parent}/{$element}/{$child}/@{$attribute}" );
                        }
                    }

                    if ( !$this->schema->isEmpty( $parent, $element, $child ) )
                    {
                        if ( $child === 'updated' )
                        {
                            // Sample date: 2003-12-13T18:30:02-05:00
                            $dataNode->set( ezcFeedTools::prepareDate( $dataNode->getValue() )->format( 'c' ) );
                        }
                        $childTag->nodeValue = ($dataNode instanceof ezcFeedElement ) ? $dataNode->__toString() : (string)$dataNode;
                    }
                }
            }
        }
    }

    /**
     * Adds the feed entry elements to the XML document being generated.
     */
    private function generateItems()
    {
        $entries = $this->get( 'items' );
        if ( $entries === null )
        {
            return;
        }

        $parent = 'entry';
        foreach ( $entries as $entry )
        {
            $entryTag = $this->xml->createElement( $parent );
            $this->channel->appendChild( $entryTag );

            foreach ( $this->schema->getRequired( $parent ) as $element )
            {
                $data = $entry->$element;

                if ( is_null( $data ) )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( "/feed/{$parent}/{$element}" );
                }

                switch ( $element )
                {
                    case 'id':
                        $dataNode = $data;
                        $this->generateNode( $entryTag, $element, null, $dataNode );
                        break;

                    case 'title':
                        $dataNode = $data;
                        if ( is_array( $data ) )
                        {
                            $dataNode = $data[0];
                        }

                        $this->generateNode( $entryTag, $element, $parent, $dataNode );
                        break;

                    case 'updated':
                        $dataNode = $data;

                        // Sample date: 2003-12-13T18:30:02-05:00
                        $dataNode->set( ezcFeedTools::prepareDate( $dataNode->getValue() )->format( 'c' ) );
                        $this->generateNode( $entryTag, $element, null, $dataNode );
                        break;
                }
            }

            // ensure the ATOM rules are applied
            $content = $entry->content;
            if ( is_array( $content ) )
            {
                $content = $content[0];
            }
            $summary = $entry->summary;
            $links = $entry->link;
            $contentPresent = !is_null( $content );
            $contentSrcPresent = $contentPresent && is_object( $content ) && !is_null( $content->src );
            $contentBase64 = true;
            if ( $contentPresent && is_object( $content )
                 && ( in_array( $content->type, array( 'text', 'html', 'xhtml', null ) )
                      || preg_match( '@[+/]xml$@i', $content->type ) !== 0
                      || substr_compare( $content->type, 'text/', 0, 5, true ) === 0 ) )
            {
                $contentBase64 = false;
            }

            $summaryPresent = !is_null( $summary );
            $linkAlternatePresent = false;
            if ( $links !== null )
            {
                foreach ( $links as $link )
                {
                    if ( $link->rel === 'alternate' )
                    {
                        $linkAlternatePresent = true;
                        break;
                    }
                }
            }

            if ( !$contentPresent )
            {
                if ( !$linkAlternatePresent && !$summaryPresent )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( '/feed/entry/content' );
                }

                if ( !$linkAlternatePresent )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( '/feed/entry/link@rel="alternate"' );
                }

                if ( !$summaryPresent )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( '/feed/entry/summary' );
                }
            }

            if ( $contentPresent )
            {
                if ( ( $contentSrcPresent || $contentBase64 ) && !$summaryPresent )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( '/feed/entry/summary' );
                }
            }


            foreach ( $this->schema->getOptional( $parent ) as $element )
            {
                $data = $entry->$element;

                if ( is_null( $data ) )
                {
                    continue;
                }

                switch ( $element )
                {
                    case 'summary':
                    case 'rights':
                        $dataNode = $data;
                        if ( is_array( $data ) )
                        {
                            $dataNode = $data[0];
                        }

                        $this->generateNode( $entryTag, $element, $parent, $dataNode );
                        break;

                    case 'content':
                        $dataNode = $data;
                        if ( is_array( $data ) )
                        {
                            $dataNode = $data[0];
                        }

                        $this->generateContentNode( $entryTag, $element, $parent, $dataNode );
                        break;

                    case 'author':
                    case 'contributor':
                        foreach ( $data as $dataNode )
                        {
                            $this->generatePerson( $entryTag, $dataNode, $element );
                        }
                        break;

                    case 'link':
                        $unique = array();
                        foreach ( $data as $dataNode )
                        {
                            if ( ( isset( $dataNode->rel ) && $dataNode->rel === 'alternate' )
                                 && isset( $dataNode->type )
                                 && isset( $dataNode->hreflang ) )
                            {
                                foreach ( $unique as $obj )
                                {
                                    if ( $obj['type'] === $dataNode->type
                                         && $obj['hreflang'] === $dataNode->hreflang )
                                    {
                                        throw new ezcFeedOnlyOneValueAllowedException( '/feed/entry/link@rel="alternate"' );
                                    }
                                }

                                $unique[] = array( 'type' => $dataNode->type,
                                                   'hreflang' => $dataNode->hreflang );

                            }

                            $this->generateNode( $entryTag, $element, null, $dataNode );
                        }
                        break;

                    case 'published':
                        $dataNode = $data;

                        // Sample date: 2003-12-13T18:30:02-05:00
                        $dataNode->set( ezcFeedTools::prepareDate( $dataNode->getValue() )->format( 'c' ) );
                        $this->generateNode( $entryTag, $element, $parent, $dataNode );
                        break;

                    case 'category':
                        foreach ( $data as $dataNode )
                        {
                            $this->generateNode( $entryTag, $element, null, $dataNode );
                        }
                        break;

                    case 'source':
                        $dataNode = $data;
                        if ( is_array( $data ) )
                        {
                            $dataNode = $data[0];
                        }

                        $this->generateSource( $entryTag, $dataNode );
                        break;
                }
            }

            $this->generateModules( $entry, $entryTag );
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed item in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed item
     * @param ezcFeedElement $element The feed element object that will contain the feed item
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseItem( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getItemsMap() );

                switch ( $tagName )
                {
                    case 'id':
                        $element->$tagName = $itemChild->textContent;
                        break;

                    case 'title':
                    case 'description':
                    case 'copyright':
                        $type = $itemChild->getAttribute( 'type' );

                        switch ( $type )
                        {
                            case 'xhtml':
                                $nodes = $itemChild->childNodes;
                                if ( $nodes instanceof DOMNodeList )
                                {
                                    $contentNode = $nodes->item( 1 );
                                    $element->$tagName = $contentNode->nodeValue;
                                }
                                $element->$tagName->type = $type;
                                break;

                            case 'html':
                                $element->$tagName = $itemChild->textContent;
                                $element->$tagName->type = $type;
                                break;

                            case 'text':
                                $element->$tagName = $itemChild->textContent;
                                $element->$tagName->type = $type;
                                break;

                            default:
                                $element->$tagName = $itemChild->textContent;
                                break;
                        }

                        $language = $itemChild->getAttribute( 'xml:lang' );
                        if ( !empty( $language ) )
                        {
                            $element->$tagName->language = $language;
                        }

                        break;

                    case 'updated':
                    case 'published':
                        $element->$tagName = ezcFeedTools::prepareDate( $itemChild->textContent );
                        break;

                    case 'author':
                    case 'contributor':
                        $subElement = $element->add( $tagName );
                        foreach ( $itemChild->childNodes as $subChild )
                        {
                            if ( $subChild->nodeType === XML_ELEMENT_NODE )
                            {
                                $subTagName = $subChild->tagName;
                                if ( in_array( $subTagName, array( 'name', 'email', 'uri' ) ) )
                                {
                                    $subElement->$subTagName = $subChild->textContent;
                                }
                            }
                        }
                        break;

                    case 'content':
                        $type = $itemChild->getAttribute( 'type' );
                        $src = $itemChild->getAttribute( 'src' );

                        switch ( $type )
                        {
                            case 'xhtml':
                                $nodes = $itemChild->childNodes;
                                if ( $nodes instanceof DOMNodeList )
                                {
                                    for ( $i = 0; $i < $nodes->length; $i++ )
                                    {
                                        if ( $nodes->item( $i ) instanceof DOMElement )
                                        {
                                            break;
                                        }
                                    }

                                    $contentNode = $nodes->item( $i );
                                    $element->$tagName = $contentNode->nodeValue;
                                }
                                $element->$tagName->type = $type;
                                break;

                            case 'html':
                                $element->$tagName = $itemChild->textContent;
                                $element->$tagName->type = $type;
                                break;

                            case 'text':
                                $element->$tagName = $itemChild->textContent;
                                $element->$tagName->type = $type;
                                break;

                            case null:
                                $element->$tagName = $itemChild->textContent;
                                break;

                            default:
                                if ( preg_match( '@[+/]xml$@i', $type ) !== 0 )
                                {
                                    foreach ( $itemChild->childNodes as $node )
                                    {
                                        if ( $node->nodeType === XML_ELEMENT_NODE )
                                        {
                                            $doc = new DOMDocument( '1.0', 'UTF-8' );
                                            $copyNode = $doc->importNode( $node, true );
                                            $doc->appendChild( $copyNode );
                                            $element->$tagName = $doc->saveXML();
                                            $element->$tagName->type = $type;
                                            break;
                                        }
                                    }
                                }
                                else if ( substr_compare( $type, 'text/', 0, 5, true ) === 0 )
                                {
                                    $element->$tagName = $itemChild->textContent;
                                    $element->$tagName->type = $type;
                                    break;
                                }
                                else // base64
                                {
                                    $element->$tagName = base64_decode( $itemChild->textContent );
                                    $element->$tagName->type = $type;
                                }
                                break;
                        }

                        if ( !empty( $src ) )
                        {
                            $element->$tagName->src = $src;
                        }

                        $language = $itemChild->getAttribute( 'xml:lang' );
                        if ( !empty( $language ) )
                        {
                            $element->$tagName->language = $language;
                        }

                        break;

                    case 'link':
                    case 'category':
                        $subElement = $element->add( $tagName );
                        if ( $itemChild->hasAttributes() )
                        {
                            foreach ( $itemChild->attributes as $attribute )
                            {
                                $subElement->{$attribute->name} = $attribute->value;
                            }
                        }
                        break;

                    case 'source':
                        $subElement = $element->add( $tagName );
                        $this->parseSource( $feed, $subElement, $itemChild );
                        break;

                    default:
                        $this->parseModules( $element, $itemChild, $tagName );
                        break;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed person (author
     * or contributor - based on $type) in the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed person
     * @param ezcFeedElement $element The feed element object that will contain the feed person
     * @param DOMElement $xml The XML element object to parse
     * @param string $type The type of the person (author, contributor)
     */
    private function parsePerson( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml, $type )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;

                switch ( $tagName )
                {
                    case 'name':
                    case 'email':
                    case 'uri':
                        $element->$tagName = $itemChild->textContent;
                        break;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed source in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed source
     * @param ezcFeedElement $element The feed element object that will contain the feed source
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseSource( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $sourceChild )
        {
            if ( $sourceChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $sourceChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getElementsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'copyright':
                    case 'description':
                        $type = $sourceChild->getAttribute( 'type' );

                        switch ( $type )
                        {
                            case 'xhtml':
                                $nodes = $sourceChild->childNodes;
                                if ( $nodes instanceof DOMNodeList )
                                {
                                    $contentNode = $nodes->item( 1 );
                                    $element->$tagName = $contentNode->nodeValue;
                                }
                                break;

                            case 'html':
                                $element->$tagName = $sourceChild->textContent;
                                break;

                            case 'text':
                                // same case as 'default'

                            default:
                                $element->$tagName = $sourceChild->textContent;
                                break;
                        }

                        break;

                    case 'id':
                    case 'generator':
                    case 'image':
                    case 'icon':
                        $element->$tagName = $sourceChild->textContent;
                        break;

                    case 'updated':
                        $element->$tagName = ezcFeedTools::prepareDate( $sourceChild->textContent );
                        break;

                    case 'category':
                    case 'link':
                        $subElement = $element->add( $tagName );
                        break;

                    case 'contributor':
                    case 'author':
                        $subElement = $element->add( $tagName );
                        $this->parsePerson( $feed, $subElement, $sourceChild, $tagName );
                        break;

                    default:
                        // check if it's part of a known module/namespace
                }
            }

            if ( $sourceChild->hasAttributes() )
            {
                foreach ( $sourceChild->attributes as $attribute )
                {
                    if ( in_array( $tagName, array( 'category', 'link' ) ) )
                    {
                        $subElement->{$attribute->name} = $attribute->value;
                    }
                    else if ( $attribute->name === 'lang' )
                    {
                        $element->$tagName->language = $attribute->value;
                    }
                    else
                    {
                        $element->$tagName->{$attribute->name} = $attribute->value;
                    }
                }
            }
        }
    }
}
?>
