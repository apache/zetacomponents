<?php
/**
 * File containing the ezcFeedEntryElement class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a feed entry.
 *
 * @property array(ezcFeedPersonElement) $author
 *                                       The authors of the entry.
 * @property array(ezcFeedCategoryElement) $category
 *                                         The categories of the entry.
 * @property ezcFeedTextElement $comments
 *                              The comments of the entry.
 * @property ezcFeedContentElement $content
 *                                 The complex text content of the entry.
 * @property array(ezcFeedPersonElement) $contributor
 *                                       The contributors of the entry.
 * @property ezcFeedTextElement $copyright
 *                              The copyright of the entry.
 * @property ezcFeedTextElement $description
 *                              The description of the entry.
 * @property array(ezcFeedLinkElement) $enclosure
 *                                     The enclosures of the entry.
 * @property ezcFeedTextElement $id
 *                              The id of the entry.
 * @property array(ezcFeedLinkElement) $link
 *                                     The links of the entry.
 * @property ezcFeedDateElement $published
 *                              The published date of the entry.
 * @property ezcFeedTextElement $title
 *                              The title of the entry.
 * @property ezcFeedDateElement $updated
 *                              The updated date of the entry.
 * @property ezcFeedSourceElement $source
 *                                The source of the entry.
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeedEntryElement extends ezcFeedElement
{
    /**
     * Holds the modules used by this feed item.
     *
     * @var array(string=>ezcFeedModule)
     */
    private $modules = array();

    /**
     * Sets the property $name to $value.
     *
     * @param string $name The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'title':
            case 'description':
            case 'comments':
            case 'copyright':
                $element = new ezcFeedTextElement();
                $element->text = $value;
                $this->properties[$name] = $element;
                break;

            case 'content':
                $element = new ezcFeedContentElement();
                $element->text = $value;
                $this->properties[$name] = $element;
                break;

            case 'author':
            case 'contributor':
                $element = new ezcFeedPersonElement();
                $element->name = $value;
                $this->properties[$name] = $element;
                break;

            case 'updated':
            case 'published':
                $element = new ezcFeedDateElement();
                $element->date = $value;
                $this->properties[$name] = $element;
                break;

            case 'id':
                $element = new ezcFeedIdElement();
                $element->id = $value;
                $this->properties[$name] = $element;
                break;

            case 'link':
                $element = new ezcFeedLinkElement();
                $element->href = $value;
                $this->properties[$name] = $element;
                break;

            case 'enclosure':
                $element = new ezcFeedLinkElement();
                $element->link = $value;
                $this->properties[$name] = $element;
                break;

            case 'source':
                $element = new ezcFeedSourceElement();
                $element->source = $value;
                $this->properties[$name] = $element;
                break;

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$name] ) )
                {
                    $this->modules[$name] = $value;
                }
                break;
        }
    }

    /**
     * Returns the value of property $name.
     *
     * @throws ezcFeedUndefinedModuleException
     *         if trying to fetch a module not defined yet
     *
     * @param string $name The property name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'author':
            case 'category':
            case 'comments':
            case 'content':
            case 'contributor':
            case 'copyright':
            case 'description':
            case 'enclosure':
            case 'id':
            case 'link':
            case 'published':
            case 'title':
            case 'updated':
            case 'source':
                if ( isset( $this->properties[$name] ) )
                {
                    return $this->properties[$name];
                }
                break;

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$name] ) )
                {
                    if ( isset( $this->$name ) )
                    {
                        return $this->modules[$name];
                    }
                    else
                    {
                        throw new ezcFeedUndefinedModuleException( $name );
                    }
                }
                break;
        }
    }

    /**
     * Returns if the property $name is set.
     *
     * @param string $name The property name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'author':
            case 'category':
            case 'comments':
            case 'content':
            case 'contributor':
            case 'copyright':
            case 'description':
            case 'enclosure':
            case 'id':
            case 'link':
            case 'published':
            case 'title':
            case 'updated':
            case 'source':
                return isset( $this->properties[$name] );

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$name] ) )
                {
                    return isset( $this->modules[$name] );
                }
        }
    }

    /**
     * Adds a new element with name $name to the feed item and returns it.
     *
     * Example:
     * <code>
     * // $item is an ezcFeedEntryElement object
     * $link = $item->add( 'link' );
     * $link->href = 'http://ez.no/';
     * </code>
     *
     * @param string $name The name of the element to add
     * @return ezcFeedElement
     */
    public function add( $name )
    {
        switch ( $name )
        {
            case 'author':
            case 'contributor':
                $element = new ezcFeedPersonElement();
                $this->properties[$name][] = $element;
                break;

            case 'id':
                $element = new ezcFeedIdElement();
                $this->properties[$name] = $element;
                break;

            case 'category':
                $element = new ezcFeedCategoryElement();
                $this->properties[$name][] = $element;
                break;

            case 'title':
            case 'description':
            case 'comments':
            case 'copyright':
                $element = new ezcFeedTextElement();
                $this->properties[$name] = $element;
                break;

            case 'content':
                $element = new ezcFeedContentElement();
                $this->properties[$name] = $element;
                break;

            case 'updated':
            case 'published':
                $element = new ezcFeedDateElement();
                $this->properties[$name] = $element;
                break;

            case 'link':
                $element = new ezcFeedLinkElement();
                $this->properties[$name][] = $element;
                break;

            case 'enclosure':
                $element = new ezcFeedEnclosureElement();
                $this->properties[$name][] = $element;
                break;

            case 'source':
                $element = new ezcFeedSourceElement();
                $this->properties[$name] = $element;
                break;

            default:
                throw new ezcFeedUnsupportedElementException( $name );
        }

        return $element;
    }

    /**
     * Adds a new module to this item and returns it.
     *
     * @param string $name The name of the module to add
     * @return ezcFeedModule
     */
    public function addModule( $name )
    {
        $this->$name = ezcFeedModule::create( $name, 'item' );
        return $this->$name;
    }

    /**
     * Returns true if the module $name is loaded, false otherwise.
     *
     * @param string $name The name of the module to check if loaded for this item
     * @return bool
     */
    public function hasModule( $name )
    {
        return isset( $this->modules[$name] );
    }

    /**
     * Returns an array with all the modules defined for this feed item.
     *
     * @return array(ezcFeedModule)
     */
    public function getModules()
    {
        return $this->modules;
    }
}
?>
