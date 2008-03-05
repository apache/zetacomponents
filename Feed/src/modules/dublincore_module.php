<?php
/**
 * File containing the ezcFeedDublinCoreModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Support for the DublinCore module: data container, generator, parser.
 *
 * Specifications: {@link http://dublincore.org/documents/dces/}.
 *
 * Create example:
 * <code>
 * // $feed is an ezcFeed object
 * $item = $feed->add( 'item' );
 * $module = $item->addModule( 'DublinCore' );
 * $creator = $module->add( 'creator' );
 * $creator->set( 'Creator name' );
 * $creator->language = 'en'; // optional
 * // more elements of the same type can be added
 * </code>
 *
 * Parse example:
 * <code>
 * // $item is an ezcFeedItem object
 * foreach ( $item->DublinCore->creator as $creator )
 * {
 *     echo $creator->__toString();
 *     echo $creator->language;
 * }
 * </code>
 *
 * @property ezcFeedElement $contributor
 *                          An entity responsible for making contributions to
 *                          the resource.
 *                          Usually the name of a person, organization or service.
 * @property ezcFeedElement $coverage
 *                          The spatial or temporal topic of the resource, the
 *                          spatial applicability of the resource, or the
 *                          jurisdiction under which the resource is relevant.
 *                          A recommended practice is to use a controlled
 *                          vocabulary such as
 *                          {@link http://www.getty.edu/research/tools/vocabulary/tgn/index.html TGN}.
 * @property ezcFeedElement $creator
 *                          An entity responsible for making the resource.
 *                          Usually the name of a person or organization.
 * @property ezcFeedElement $date
 *                          A point or period of time associated with an event
 *                          in the lifecycle of the resource. It is a Unix
 *                          timestamp, which will be converted to an
 *                          {@link http://www.w3.org/TR/NOTE-datetime ISO 8601}
 *                          date when generating the feed.
 * @property ezcFeedElement $description
 *                          A description of the resource.
 * @property ezcFeedElement $format
 *                          The file format, physical medium, or dimensions of
 *                          the resource.
 *                          Recommended best practices is to use a controlled
 *                          vocabulary such as the list of
 *                          {@link http://www.iana.org/assignments/media-types/ Internet Media Types}
 *                          (MIME).
 * @property ezcFeedElement $identifier
 *                          An unambiguous reference to the resource within a
 *                          given context.
 * @property ezcFeedElement $language
 *                          A language of the resource.
 *                          Recommended best practice is to use a controlled
 *                          vocabulary such as
 *                          {@link http://www.faqs.org/rfcs/rfc4646.html RFC 4646}.
 * @property ezcFeedElement $publisher
 *                          An entity responsible for making the resource available.
 *                          Usually the name of a person, organization or service.
 * @property ezcFeedElement $relation
 *                          A related resource.
 * @property ezcFeedElement $rights
 *                          Information about rights held in and over the resource.
 * @property ezcFeedElement $source
 *                          A related resource from which the described resource
 *                          is derived.
 * @property ezcFeedElement $subject
 *                          The topic of the resource.
 * @property ezcFeedElement $title
 *                          The name given to the resource.
 * @property ezcFeedElement $type
 *                          The nature or genre of the resource.
 *                          Recommended best practice is to use a controlled
 *                          vocabulary such as the
 *                          {@link http://dublincore.org/documents/dcmi-type-vocabulary/ DCMI Type Vocabulary}
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedDublinCoreModule extends ezcFeedModule
{
    /**
     * Holds the schema for this feed module.
     *
     * @var array(string)
     * @ignore
     */
    protected $schema = array(
        'feed' => array(),
        'item' => array( 'contributor' => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'coverage'    => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'creator'     => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'date'        => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'description' => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'format'      => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'identifier'  => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'language'    => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'publisher'   => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'relation'    => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'rights'      => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'source'      => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'subject'     => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'title'       => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),

                         'type'        => array( '#' => 'string',
                                                 'ATTRIBUTES' => array( 'language' => 'string' ) ),
                         ) );

    /**
     * Constructs a new ezcFeedDublinCoreModule object.
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
                        case 'date':
                            $elementTag->nodeValue = ezcFeedTools::prepareDate( $values->getValue() )->format( 'c' );
                            break;

                        default:
                            $elementTag->nodeValue = $values->__toString();
                            break;
                    }

                    if ( isset( $values->language ) )
                    {
                        $langTag = $xml->createAttribute( 'xml:lang' );
                        $val = $xml->createTextNode( $values->language );
                        $langTag->appendChild( $val );
                        $elementTag->appendChild( $langTag );
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
                case 'date':
                    $element->set( ezcFeedTools::prepareDate( $value ) );
                    break;

                default:
                    $element->set( $value );
            }

            foreach ( ezcFeedTools::getAttributes( $node ) as $attr => $value )
            {
                switch ( $attr )
                {
                    case 'lang':
                        $element->language = $value;
                        break;
                }
            }
        }
    }

    /**
     * Returns the module name ('DublinCore').
     *
     * @return string
     */
    public function getModuleName()
    {
        return 'DublinCore';
    }

    /**
     * Returns the namespace for this module ('http://purl.org/dc/elements/1.1/').
     *
     * @return string
     */
    public function getNamespace()
    {
        return 'http://purl.org/dc/elements/1.1/';
    }

    /**
     * Returns the namespace prefix for this module ('dc').
     *
     * @return string
     */
    public function getNamespacePrefix()
    {
        return 'dc';
    }
}
?>
