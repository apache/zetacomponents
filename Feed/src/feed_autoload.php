<?php
/**
 * Autoloader definition for the Feed component.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

return array(
    'ezcFeed'                            => 'Feed/feed.php',
    'ezcFeedItem'                        => 'Feed/feed_item.php',
    
    'ezcFeedParser'                      => 'Feed/interfaces/parser.php',
    'ezcFeedProcessor'                   => 'Feed/interfaces/processor.php',
    'ezcFeedRss'                         => 'Feed/processors/rss.php',
    'ezcFeedRss1'                        => 'Feed/processors/rss1.php',
    'ezcFeedRss2'                        => 'Feed/processors/rss2.php',
    'ezcFeedAtom'                        => 'Feed/processors/atom.php',

    'ezcFeedModule'                      => 'Feed/interfaces/module.php',
    'ezcFeedModuleDublinCore'            => 'Feed/modules/dublin_core.php',
    'ezcFeedModuleData'                  => 'Feed/structs/module_data.php',
    'ezcFeedItemModuleData'              => 'Feed/structs/item_module_data.php',

    'ezcFeedException'                   => 'Feed/exceptions/exception.php',
    'ezcFeedCanNotParseException'        => 'Feed/exceptions/can_not_parse.php',
    'ezcFeedItemNrOutOfRangeException'   => 'Feed/exceptions/item_nr_out_of_range.php',
    'ezcFeedParseErrorException'         => 'Feed/exceptions/parse_error.php',
    'ezcFeedRequiredItemDataMissingException' => 'Feed/exceptions/item_data_missing.php',
    'ezcFeedRequiredMetaDataMissingException' => 'Feed/exceptions/meta_data_missing.php',
    'ezcFeedUnsupportedModuleException'  => 'Feed/exceptions/unsupported_module.php',
    'ezcFeedUnsupportedModuleElementException'  => 'Feed/exceptions/unsupported_module_element.php',
    'ezcFeedUnsupportedTypeException'    => 'Feed/exceptions/unsupported_type.php',
);
?>
