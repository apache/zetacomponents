<?php
/**
 * Autoloader definition for the Feed component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

return array(
    'ezcFeedException'                             => 'Feed/exceptions/exception.php',
    'ezcFeedAtLeastOneItemDataRequiredException'   => 'Feed/exceptions/one_item_data_required.php',
    'ezcFeedCanNotParseException'                  => 'Feed/exceptions/can_not_parse.php',
    'ezcFeedOnlyOneValueAllowedException'          => 'Feed/exceptions/only_one_value_allowed.php',
    'ezcFeedParseErrorException'                   => 'Feed/exceptions/parse_error.php',
    'ezcFeedRequiredItemDataMissingException'      => 'Feed/exceptions/item_data_missing.php',
    'ezcFeedRequiredMetaDataMissingException'      => 'Feed/exceptions/meta_data_missing.php',
    'ezcFeedUnsupportedModuleElementException'     => 'Feed/exceptions/unsupported_module_element.php',
    'ezcFeedUnsupportedModuleException'            => 'Feed/exceptions/unsupported_module.php',
    'ezcFeedUnsupportedModuleItemElementException' => 'Feed/exceptions/unsupported_module_item_element.php',
    'ezcFeedUnsupportedTypeException'              => 'Feed/exceptions/unsupported_type.php',
    'ezcFeedParser'                                => 'Feed/interfaces/parser.php',
    'ezcFeedProcessor'                             => 'Feed/interfaces/processor.php',
    'ezcFeedModule'                                => 'Feed/interfaces/module.php',
    'ezcFeedRss'                                   => 'Feed/processors/rss.php',
    'ezcFeed'                                      => 'Feed/feed.php',
    'ezcFeedAtom'                                  => 'Feed/processors/atom.php',
    'ezcFeedItem'                                  => 'Feed/feed_item.php',
    'ezcFeedItemModuleData'                        => 'Feed/structs/item_module_data.php',
    'ezcFeedModuleContent'                         => 'Feed/modules/content.php',
    'ezcFeedModuleData'                            => 'Feed/structs/module_data.php',
    'ezcFeedModuleDublinCore'                      => 'Feed/modules/dublin_core.php',
    'ezcFeedRss1'                                  => 'Feed/processors/rss1.php',
    'ezcFeedRss2'                                  => 'Feed/processors/rss2.php',
);
?>
