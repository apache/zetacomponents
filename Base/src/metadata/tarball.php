<?php
/**
 * File containing the ezcBaseMetaDataTarballReader class.
 *
 * @package Base
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class implements ways of fetching information about the installed
 * eZ Components when installed as tarball.
 *
 * @package Base
 * @version //autogentag//
 * @mainclass
 */
class ezcBaseMetaDataTarballReader
{
    private $xml;

    public function __construct()
    {
        $this->xml = simplexml_load_file( dirname( __FILE__ ) . '/../../../release-info.xml' );
    }

    public function getBundleVersion()
    {
        return (string) $this->xml->{'release-info'}->version;
    }

    public function getRequiredPhpVersion()
    {
        return (string) $this->xml->{'release-info'}->deps->php;
    }

    public function isComponentInstalled( $componentName )
    {
        $root = $this->xml->{'release-info'}->deps->packages;

        foreach ( $root as $packages )
        {
            if ( (string) $packages->package == $componentName )
            {
                return true;
            }
        }
        return false;
    }

    public function getComponentVersion( $componentName )
    {
        $root = $this->xml->{'release-info'}->deps->packages;

        foreach ( $root as $packages )
        {
            if ( (string) $packages->package == $componentName )
            {
                return (string) $packages->package['version'];
            }
        }
        return false;
    }
}
?>
