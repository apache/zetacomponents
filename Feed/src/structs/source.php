<?php
/**
 * File containing the ezcFeedSourceElement class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a feed source element.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedSourceElement extends ezcFeedElement
{
    /**
     * The authors of the entry.
     *
     * @var string
     */
    public $source;

    /**
     * The categories of the entry.
     *
     * @var string
     */
    public $url;

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
            case 'copyright':
                $element = new ezcFeedTextElement();
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
                $element = new ezcFeedDateElement();
                $element->date = $value;
                $this->properties[$name] = $element;
                break;

            case 'generator':
                $element = new ezcFeedGeneratorElement();
                $element->name = $value;
                $this->properties[$name] = $element;
                break;

            case 'image':
            case 'icon':
                $element = new ezcFeedImageElement();
                $element->link = $value;
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

            case 'category':
                $element = new ezcFeedCategoryElement();
                $element->term = $value;
                $this->properties[$name] = $element;
                break;

            default:
                parent::__set( $name, $value );
                break;
        }
    }

    /**
     * Returns the value of property $name.
     *
     * @param string $name The property name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'title':
            case 'description':
            case 'copyright':
            case 'author':
            case 'contributor':
            case 'updated':
            case 'generator':
            case 'image':
            case 'icon':
            case 'id':
            case 'link':
            case 'category':
                if ( isset( $this->properties[$name] ) )
                {
                    return $this->properties[$name];
                }
                break;

            default:
                return parent::__get( $name );
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
            case 'title':
            case 'description':
            case 'copyright':
            case 'author':
            case 'contributor':
            case 'updated':
            case 'generator':
            case 'image':
            case 'icon':
            case 'id':
            case 'link':
            case 'category':
                return isset( $this->properties[$name] );

            default:
                return parent::__isset( $name );
        }
    }

    /**
     * Adds a new element with name $name to the source element and returns it.
     *
     * Example:
     * <code>
     * // $source is an ezcFeedSourceElement object
     * $link = $source->add( 'link' );
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
            case 'copyright':
                $element = new ezcFeedTextElement();
                $this->properties[$name] = $element;
                break;

            case 'generator':
                $element = new ezcFeedGeneratorElement();
                $this->properties[$name] = $element;
                break;

            case 'image':
            case 'icon':
                $element = new ezcFeedImageElement();
                $this->properties[$name] = $element;
                break;

            case 'updated':
                $element = new ezcFeedDateElement();
                $this->properties[$name] = $element;
                break;

            case 'link':
                $element = new ezcFeedLinkElement();
                $this->properties[$name][] = $element;
                break;

            default:
                throw new ezcFeedUnsupportedElementException( $name );
        }

        return $element;
    }

    /**
     * Returns the source attribute.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->source . '';
    }
}
?>
