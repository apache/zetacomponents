<?php
/**
 * @package Configuration
 * @subpackage Examples
 */

require 'autoload.php';

// A small example which creates an INI file from scratch
//
// If something goes wrong (file writing or setting access) it will catch
// the exception and show the problem.

try
{
    $conf = new ezcConfiguration();
    $conf->setSetting( 'db', 'title', "This is the title" );

    $conf->setSettings(
        'db',
        array( "host", "user", "password" ),
        array( 'localhost', 'dr', '42' )
    );

    $ini = new ezcConfigurationIniWriter( dirname( __FILE__ ) . '/defaults.ini', $conf );
    $conf = $ini->save();
    print "INI file defaults.ini was successfully created\n";
}
catch ( Exception $e )
{
    print "Caught exception while reading INI\n";
    print $e->getMessage() . "(" . $db->getCode() . ")\n";
    print $e->getTraceAsString() . "\n";
}

?>
