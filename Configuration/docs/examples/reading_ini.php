<?php
/**
 * @package Configuration
 * @subpackage Examples
 */

require 'autoload.php';

// A small example which reads an INI file and reads out some settings
//
// If something goes wrong (file reading or setting access) it will catch
// the exception and show the problem.

try
{
    $ini = new ezcConfigurationIniReader( dirname( __FILE__ ) . '/settings.ini' );
    $conf = $ini->load();

    $title = $conf->getSetting( 'site', 'title' );

    print "Title is $title\n";

    $settings = $conf->getSettings( 'db', array( 'host', 'user', 'password' ) );
    print "Connecting to database at '{$settings['host']}' with user '{$settings['user']}' and password '{$settings['password']}'\n";

    if ( $conf->hasSetting( 'db', 'socket' ) )
        print 'Socket: ' . $conf->getSetting( 'db', 'socket' ) . "\n";
}
catch ( Exception $e )
{
    print "Caught exception while reading INI file\n";
    print $e->getMessage() . "(" . $e->getCode() . ")\n";
    print $e->getTraceAsString() . "\n";
}

?>
