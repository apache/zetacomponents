<?php
/**
 * File containing the ezcFeedContentElement class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a complex text element.
 *
 * @property string $src
 *                  An URL to the source of the value specified in the text property.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedContentElement extends ezcFeedTextElement
{
    /**
     * The link to the source.
     *
     * @var string
     */
    public $src;
}
?>
