<?php
/**
 * File containing the ezcTranslationTsBackendOptions class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct class to store the options of the ezcTranslationTsBackend class.
 *
 * This class stores the options for the {@link ezcTranslationTsBackend} class.
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcTranslationTsBackendOptions extends ezcBaseOptions
{
    /**
     * Path to the directory that contains all TS .xml files
     * 
     * @var string
     */
    protected $location = "";

    /**
     * Format for the translation file's name
     *
     * In this format string the special place holder [LOCALE] will be replaced
     * with the requested locale's name. For example a format of
     * "translations/[LOCALE].xml" will result in the filename for the
     * translation file to be "translations/nl_NL.xml" if the nl_NL locale is
     * requested.
     *
     * @var string
     */
    protected $format = '[LOCALE].xml';

    /**
     * Property write access.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseSettingValueException
     *         If a desired property value is out of range.
     *
     * @param string $propertyName Name of the property.
     * @param mixed $val  The value for the property.
     * @return void
     */
    public function __set( $propertyName, $val )
    {
        switch ( $propertyName )
        {
            case 'location':
                if ( $val[strlen( $val ) - 1] != '/' )
                {
                    $val .= '/';
                }
                break;
            case 'format':
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $propertyName );
        }
        $this->$propertyName = $val;
    }
}

?>
