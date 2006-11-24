<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Implements the ComplementEmpty translation filter.
 *
 * The filter replaces a missing translated string with its original.
 *
 * @package Translation
 * @version //autogentag//
 * @mainclass
 */
class ezcTranslationComplementEmptyFilter implements ezcTranslationFilter
{
    /**
     * Singleton instance
     * @var ezcTranslationFilterBork
     */
    static private $instance = null;

    /**
     * Private constructor to prevent non-singleton use.
     */
    private function __construct()
    {
    }

    /**
     * Returns an instance of the class ezcTranslationFilterBork.
     *
     * @return ezcTranslationFilterBork Instance of ezcTranslationFilterBork
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new ezcTranslationComplementEmptyFilter();
        }
        return self::$instance;
    }

    /**
     * Filters the context $context.
     *
     * Applies the fillin filter on the given context. The filter replaces a
     * missing translated string with its original.
     *
     * @param array(ezcTranslationData) $context
     * @return void
     */
    public function runFilter( array $context )
    {
        foreach ( $context as $element )
        {
            if ( $element->status == ezcTranslationData::UNFINISHED )
            {
                $element->translation = $element->original;
            }
        }
    }
}
?>
