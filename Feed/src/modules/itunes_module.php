<?php
/**
 * File containing the ezcFeedITunesModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Support for the iTunes module: data container, generator, parser.
 *
 * Specifications: {@link http://www.apple.com/itunes/store/podcaststechspecs.html}.
 *
 * Create example:
 * <code>
 * // $feed is an ezcFeed object
 * $item = $feed->add( 'item' );
 * $module = $item->addModule( 'iTunes' );
 * $category = $module->add( 'category' );
 * $category->text = 'Category name';
 * // add a sub-category
 * $subCategory = $category->add( 'category' );
 * $subCategory->text = 'Sub-category name';
 * </code>
 *
 * Parse example:
 * <code>
 * // $feed is an ezcFeed object
 * if ( isset( $feed->iTunes ) )
 * {
 *     $iTunes = $feed->iTunes;
 *     if ( isset( $iTunes->category ) )
 *     {
 *         foreach ( $iTunes->category as $category )
 *         {
 *             echo $category->text;
 *             if ( isset( $category->category ) )
 *             {
 *                 foreach ( $category->category as $subCategory )
 *                 {
 *                     echo $subCategory->text;
 *                 }
 *             }
 *         }
 *     }
 * }
 * </code>
 *
 * @property ezcFeedElement $author
 *                          The author of a resource. Can appear at both
 *                          feed-level and item-level.
 * @property ezcFeedElement $block
 *                          Prevents a feed or a feed item to appear. Can appear
 *                          at both feed-level and item-level. Valid values are 'yes'
 *                          and 'no', default 'no'.
 * @property ezcFeedElement $category
 *                          Categories for a feed. Can appear at feed-level only.
 *                          Multiple categories can be specified, and categories
 *                          can have sub-categories. The ampersands (&) in categories
 *                          must be escaped to &amp;.
 *                          {@link http://www.apple.com/itunes/store/podcaststechspecs.html#categories Valid iTunes categories}
 * @property ezcFeedElement $duration
 *                          The duration of a feed item. Can appear at item-level
 *                          only. Can be specified as HH:MM:SS, H:MM:SS, MM:SS,
 *                          M:SS or S (H = hours, M = minutes, S = seconds).
 * @property ezcFeedElement $explicit
 *                          Specifies if a feed or feed-item contains explicit
 *                          content. Can appear at both feed-level and item-level.
 *                          Valid values are 'clean', 'no' and 'yes', default 'no'.
 * @property ezcFeedElement $image
 *                          A link to an image for the feed. Can appear at both
 *                          feed-level and item-level only. The
 *                          {@link http://www.apple.com/itunes/store/podcaststechspecs.html iTunes specifications}
 *                          say that image is supported at feed-level only, but there
 *                          are many podcasts using image at item-level also, and there
 *                          are software applications supporting image at item-level too.
 *                          Use image at item-level at your own risk, as some software
 *                          applications might not support it. The Feed component supports
 *                          parsing and generating feeds with image at both feed-level and item-level.
 * @property ezcFeedElement $keywords
 *                          A list of keywords for a feed or feed item. Can appear
 *                          at both feed-level and item-level. The keywords should
 *                          be separated by commas.
 * @property ezcFeedElement $newfeedurl
 *                          A new URL for the feed. Can appear at feed-level only. In
 *                          XML it will appear as 'new-feed-url'.
 * @property ezcFeedElement $owner
 *                          The owner of the feed. Can appear at feed-level only.
 * @property ezcFeedElement $subtitle
 *                          Short description of a feed or feed item. Can appear
 *                          at both feed-level and item-level.
 * @property ezcFeedElement $summary
 *                          Longer description of a feed or feed item. Can appear
 *                          at both feed-level and item-level.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedITunesModule extends ezcFeedModule
{
    /**
     * Holds the schema for this feed module.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $schema = array(
        'feed' => array( 'author'       => array( '#' => 'string' ),
                         'block'        => array( '#' => 'string' ),
                         'category'     => array( '#' => 'string',
                                                  'ATTRIBUTES' => array( 'text' => 'string' ),
                                                  'NODES'      => array( 'category' => array( '#'          => 'string',
                                                                                              'ATTRIBUTES' => array( 'text' => 'string' ) ) ) ),
                         'explicit'     => array( '#' => 'string' ),
                         'image'        => array( '#' => 'none',
                                                  'ATTRIBUTES' => array( 'href' => 'string' ) ),

                         'keywords'     => array( '#' => 'string' ),
                         'newfeedurl'   => array( '#' => 'string' ), // in XML is new-feed-url
                         'owner'        => array( '#' => 'string',
                                                  'NODES' => array( 'email' => array( '#' => 'string' ),
                                                                    'name'  => array( '#' => 'string' ) ) ),

                         'subtitle'     => array( '#' => 'string' ),
                         'summary'      => array( '#' => 'string' ),
            ),

        'item' => array( 'author'       => array( '#' => 'string' ),
                         'block'        => array( '#' => 'string' ),
                         'duration'     => array( '#' => 'string' ),
                         'explicit'     => array( '#' => 'string' ),

                         // image at item-level is NOT supported by the specifications,
                         // but it is used widely in podcasts and software applications
                         'image'        => array( '#' => 'none',
                                                  'ATTRIBUTES' => array( 'href' => 'string' ) ),

                         'keywords'     => array( '#' => 'string' ),
                         'subtitle'     => array( '#' => 'string' ),
                         'summary'      => array( '#' => 'string' ),
            ) );

    /**
     * Constructs a new ezcFeedITunesModule object.
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
                $elementName = ( $element === 'newfeedurl' ) ? 'new-feed-url' : $element;
                foreach ( $this->$element as $values )
                {
                    $elementTag = $xml->createElement( $this->getNamespacePrefix() . ':' . $elementName );
                    $root->appendChild( $elementTag );

                    switch ( $elementName )
                    {
                        case 'category':
                            // generate sub-categories
                            if ( isset( $values->category ) && count( $values->category ) > 0 )
                            {
                                $subCategory = $values->category[0];
                                $tag = $xml->createElement( $this->getNamespacePrefix() . ':' . 'category' );
                                $textTag = $xml->createAttribute( 'text' );
                                $val = $xml->createTextNode( $subCategory->text );
                                $textTag->appendChild( $val );
                                $tag->appendChild( $textTag );
                                $elementTag->appendChild( $tag );
                            }

                            if ( isset( $values->text ) )
                            {
                                $textTag = $xml->createAttribute( 'text' );
                                $val = $xml->createTextNode( $values->text );
                                $textTag->appendChild( $val );
                                $elementTag->appendChild( $textTag );
                            }
                            break;

                        case 'image':
                            if ( isset( $values->href ) )
                            {
                                $textTag = $xml->createAttribute( 'href' );
                                $val = $xml->createTextNode( $values->href );
                                $textTag->appendChild( $val );
                                $elementTag->appendChild( $textTag );
                            }
                            break;

                        case 'owner':
                            foreach ( array( 'email', 'name' ) as $subElement )
                            {
                                if ( isset( $values->$subElement ) )
                                {
                                    $tag = $xml->createElement( $this->getNamespacePrefix() . ':' . $subElement );
                                    $val = $xml->createTextNode( $values->$subElement );
                                    $tag->appendChild( $val );
                                    $elementTag->appendChild( $tag );
                                }
                            }

                            break;

                        default:
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
        if ( $name === 'new-feed-url' )
        {
            $name = 'newfeedurl';
        }

        if ( $this->isElementAllowed( $name ) )
        {
            $element = $this->add( $name );
            $value = $node->textContent;

            switch ( $name )
            {
                case 'category':
                    foreach ( $node->childNodes as $subNode )
                    {
                        if ( get_class( $subNode ) === 'DOMElement' )
                        {
                            $subCategory = $element->add( $name );

                            if ( $subNode->hasAttributes() )
                            {
                                foreach ( $subNode->attributes as $attribute )
                                {
                                    $subCategory->{$attribute->name} = $attribute->value;
                                }
                            }
                        }
                    }
                    break;

                case 'image':
                    // no textContent in $node
                    break;

                case 'owner':
                    foreach ( $node->childNodes as $subNode )
                    {
                        if ( get_class( $subNode ) === 'DOMElement' )
                        {
                            switch ( $subNode->nodeName )
                            {
                                case 'itunes:email':
                                    $element->email = $subNode->textContent;
                                    break;

                                case 'itunes:name':
                                    $element->name = $subNode->textContent;
                                    break;
                            }
                        }
                    }
                    break;

                default:
                    $element->set( $value );
            }

            if ( $node->hasAttributes() )
            {
                foreach ( $node->attributes as $attribute )
                {
                    $element->{$attribute->name} = $attribute->value;
                }
            }
        }
    }

    /**
     * Returns the module name ('iTunes').
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'iTunes';
    }

    /**
     * Returns the namespace for this module ('http://www.itunes.com/dtds/podcast-1.0.dtd').
     *
     * @return string
     */
    public static function getNamespace()
    {
        return 'http://www.itunes.com/dtds/podcast-1.0.dtd';
    }

    /**
     * Returns the namespace prefix for this module ('itunes').
     *
     * @return string
     */
    public static function getNamespacePrefix()
    {
        return 'itunes';
    }
}
?>
