<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Locale
 */
/**
 * With this class you can format numbers and dates in a locale aware fashion.
 *
 * This class uses the default locale, or the one passed in the constructor, to
 * format numbers, dates and currencies.
 *
 * Example using the default locale (Norwegian Bokmål in the example):
 * <code>
 * <?php
 *     $date = date_create( 'now' );
 *     $locale = new ezcLocale();
 * 
 *     // shows "kl. 02.49.15 GMT-05:00 torsdag 18. august 2005"
 *     $locale->formatDate( $date, DATETIME_FORMAT_FULL, DATETIME_FORMAT_FULL );
 * 
 *     // shows "torsdag august 18 2005, 02:49"
 *     $locale->formatDateCustom( $date, 'l F d Y, H:i' );
 * 
 *     // shows "kr 31 415,92"
 *     $locale->formatCurrency( 31415.92, 'NOK' );
 * 
 *     // shows "SKr 31 415,92"
 *     $locale->formatCurrency( 31415.92, 'SEK' );
 * 
 *     // shows "1 457%"
 *     $locale->formatNumber( 1457.1, FORMAT_PERCENT );
 * ?>
 * </code>
 * 
 * Example with defined locale (Dutch/the Netherlands):
 * <code>
 * <?php
 *     $locale = new ezcLocale( 'nl_NL' );
 *     // shows "zeven en zestig duizend acht honderd negentig"
 *     $locale->formatNumber( 67890, FORMAT_SPELLOUT );
 * 
 *     // shows "NKr 31.415,92"
 *     $locale->formatCurrency( 31415.92, 'NOK' );
 *
 *     // shows "€ 1.234,57"
 *     $locale->formatNumber( 1234.567, FORMAT_CUSTOM, '¤ #,##0.00' );
 * ?> 
 * </code>
 *
 * Example for parsing localized dates:
 * <code>
 * <?php
 *     $locale = new ezcLocale( 'no_NO' );
 *     $date = $locale->parseDate( "17 mai 2005" );
 *     // shows "2005-05-17T00:00:00+0000. Date's formatLocale() uses the
 *     // default locale.
 *     echo $date->formatLocale( date::ISO8601 );
 *
 *     $locale = new ezcLocale( 'nl_NL' );
 *     // shows "17 mei 2005"
 *     echo $locale->formatCustomDate( $date, 'j F Y' );
 * ?>
 * </code>
 *
 * @package Locale
 */
class ezcLocale
{
	const DATETIME_FORMAT_FULL =    1;
	const DATETIME_FORMAT_LONG =    2;
	const DATETIME_FORMAT_MEDIUM =  3;
	const DATETIME_FORMAT_SHORT =   4;
	const DATETIME_FORMAT_DEFAULT = 5;
	const DATETIME_FORMAT_NONE =    6;

	const FORMAT_DECIMAL    = 1;
	const FORMAT_PERCENT    = 2;
	const FORMAT_SCIENTIFIC = 3;
	const FORMAT_ORDINAL    = 4;
	const FORMAT_SPELLOUT   = 5;
	const FORMAT_CUSTOM     = 1;

	/**
	 * @var string The locale that was passed through the contructor
	 */
	private $locale;

	/**
	 * Constructs a ezcLocale object
	 *
	 * This constructor creates a new ezcLocale object for the default locale,
	 * unless the $locale parameter is given. Locale names consist of a
	 * {@link http://ftp.ics.uci.edu/pub/ietf/http/related/iso639.txt two
	 * letter language code} followed by an
	 * underscore and a {@link
	 * http://userpage.chemie.fu-berlin.de/diverse/doc/ISO_3166.html two letter
	 * ISO 3166 country code}.
	 *
	 * @param string $locale
	 */
	function __construct( $locale = false )
	{
	}

	/**
	 * Formats a date/time according to the locale
	 *
	 * With this function you can format a PHP Date object according to the
	 * locale. You can specify the date and time format by using the
	 * DATETIME_FORMAT constants. The method figures out whether the date or
	 * time component should be placed first in the resulting format. Use
	 * DATETIME_FORMAT_NONE if you don't want either the date or time to be
	 * there in the returned string. 
	 * @see ezcLocale::formatCustomDate if you want to format your date with a
	 * user defined format.
	 *
	 * @param Date    $date
	 * @param int $dateFormat
	 * @param int $timeFormat
	 * @return string
	 */
	function formatDate( Date $date, $dateFormat, $timeFormat )
	{
	}

	/**
	 * Formats a date with localized day names and month names.
	 *
	 * This function allows you to specify a $formatString to format a PHP Date
	 * object. The formatting string can consist of the same formatters as the
	 * PHP function {@link http://php.net/date date()} uses.
	 *
	 * @param Date   $date
	 * @param string $formatString
	 * @return string
	 */
	function formatCustomDate( Date $date, $formatString )
	{
	}

    /**
     * Parses a string containing localized date/time information.
     *
     * With this function you can parse a string into a PHP Date object. The
     * class' assigned locale is used to provide the necessary strings such as
     * januar, agust, lørdag to the parser. This function only wraps around
     * PHP's date_create() function, but providing automatic switching of the
     * locale if necessary.
     *
     * @param string $datetime
     * @return Date
     */
    function parseDate( $datetime )
    {
    }

	/**
	 * Formats a number as a currency value.
	 *
	 * This function uses the locale's rules for formatting a number as a
	 * monetairy value. The $currencyCode is a three letter currency code as
	 * described in {@link http://www.xe.com/iso4217.htm ISO 4217}. This
	 * function will format the currency code according to the current locale
	 * too - for example the code "EUR" results in "�" in the returned string.
	 *
	 * @param float  $value
	 * @param string $currencyCode
	 * @return string
	 */
	function formatCurrency( $value, $currencyCode )
	{
	}

	/**
	 * Formats a number according to the current locale.
	 *
	 * The $pattern parameter is only allowed for FORMAT_CUSTOM and consists of
	 * the rules as outlined {@link
	 * http://icu.sourceforge.net/apiref/icu4c/classDecimalFormat.html#_details here}
	 */
	function formatNumber ( $value, $type, $pattern = '' )
	{
	}
}
?>
