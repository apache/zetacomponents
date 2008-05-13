<?php
/**
 * Autoloader definition for the Feed component.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

return array(
    'ezcFeedException'                           => 'Feed/exceptions/exception.php',
    'ezcFeedAtLeastOneItemDataRequiredException' => 'Feed/exceptions/one_item_data_required.php',
    'ezcFeedOnlyOneValueAllowedException'        => 'Feed/exceptions/only_one_value_allowed.php',
    'ezcFeedParseErrorException'                 => 'Feed/exceptions/parse_error.php',
    'ezcFeedRequiredMetaDataMissingException'    => 'Feed/exceptions/meta_data_missing.php',
    'ezcFeedUndefinedModuleException'            => 'Feed/exceptions/undefined_module.php',
    'ezcFeedUnsupportedElementException'         => 'Feed/exceptions/unsupported_element.php',
    'ezcFeedUnsupportedModuleException'          => 'Feed/exceptions/unsupported_module.php',
    'ezcFeedUnsupportedTypeException'            => 'Feed/exceptions/unsupported_type.php',
    'ezcFeedElement'                             => 'Feed/nodes/element.php',
    'ezcFeedModule'                              => 'Feed/interfaces/module.php',
    'ezcFeedParser'                              => 'Feed/interfaces/parser.php',
    'ezcFeedProcessor'                           => 'Feed/interfaces/processor.php',
    'ezcFeed'                                    => 'Feed/feed.php',
    'ezcFeedAtom'                                => 'Feed/processors/atom.php',
    'ezcFeedContentModule'                       => 'Feed/modules/content_module.php',
    'ezcFeedCreativeCommonsModule'               => 'Feed/modules/creativecommons_module.php',
    'ezcFeedDublinCoreModule'                    => 'Feed/modules/dublincore_module.php',
    'ezcFeedGeoModule'                           => 'Feed/modules/geo_module.php',
    'ezcFeedITunesModule'                        => 'Feed/modules/itunes_module.php',
    'ezcFeedItem'                                => 'Feed/nodes/item.php',
    'ezcFeedRss1'                                => 'Feed/processors/rss1.php',
    'ezcFeedRss2'                                => 'Feed/processors/rss2.php',
    'ezcFeedSchema'                              => 'Feed/structs/feed_schema.php',
    'ezcFeedTools'                               => 'Feed/tools/feed_tools.php',
);
?>
