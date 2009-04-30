<?php
/**
 * File containing the ezcBaseMetaData class.
 *
 * @package Base
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class implements ways of fetching information about the installed
 * eZ Components.
 *
 * @package Base
 * @version //autogentag//
 * @mainclass
 */
class ezcBaseMetaData
{
    public function __construct( $installMethod = NULL )
    {
        $installMethod = $installMethod !== NULL ? $installMethod : ezcBase::getInstallMethod();

        // figure out which reader to use
        switch ( $installMethod )
        {
            case 'tarball':
                $this->reader = new ezcBaseMetaDataTarballReader;
                break;
            case 'pear':
                $this->reader = new ezcBaseMetaDataPearReader;
                break;
            default:
                throw new ezcBaseMetaDataReaderException( "Unknown install method '$installMethod'." );
                break;
        }
    }

    public function getBundleVersion()
    {
        return $this->reader->getBundleVersion();
    }

    public function getRequiredPhpVersion()
    {
        return $this->reader->getRequiredPhpVersion();
    }

    public function isComponentInstalled( $componentName )
    {
        return $this->return->isComponentInstalled( $componentName );
    }

    public function getComponentVersion( $componentName )
    {
        return $this->return->getComponentVersion( $componentName );
    }
}
?>
