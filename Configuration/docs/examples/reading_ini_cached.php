<?php
/**
 * @package Configuration
 * @subpackage Examples
 */

require 'autoload.php';

// A small example which reads an INI file and reads out some settings
// It uses the array reader/writer to cache the INI file.
//
// If something goes wrong (file reading or setting access) it will catch
// the exception and show the problem.

try
{
    $ini = new ezcConfigurationArrayReader( dirname( __FILE__ ) . '/settings.php' );
    if ( !$ini->configExists() )
    {
        print "Cache does not exist, generating\n";
        // Cache is not present so we read the original file
        $ini = new ezcConfigurationIniReader( dirname( __FILE__ ) . '/settings.ini' );
        $conf = $ini->load();
        // Write back the cache
        $cache = new ezcConfigurationArrayWriter( dirname( __FILE__ ) . '/settings.php', $conf );
        $cache->save();
    }
    else
    {
        print "Reading from cache\n";
        $conf = $ini->load();
    }

    $title = $conf->getSetting( 'site', 'title' );

    print "Title is $title\n";
}
catch ( Exception $e )
{
    print "Caught exception while reading INI file\n";
    print $e->getMessage() . "(" . $e->getCode() . ")\n";
    print $e->getTraceAsString() . "\n";
}

?>
