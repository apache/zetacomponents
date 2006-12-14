<?php
// Run the regression tests but then without PHPUnit.
// Made it to watch the memory consumption.

include ("Base/src/base.php");
include("PHPUnit/Util/Filter.php");

include_once ("custom_blocks/testblocks.php");
include_once ("custom_blocks/links.php");
include_once ("custom_blocks/cblock.php");
include_once ("custom_blocks/sha1.php");



function __autoload( $className )
{
    ezcBase::autoload( $className );
}

    function readDirRecursively( $dir, &$total, $onlyWithExtension = false) 
    {
        $extensionLength = strlen( $onlyWithExtension );
        $path = opendir( $dir );

        while ( false !== ( $file = readdir( $path ) ) ) 
        {
            if ( $file != "." && $file != ".." ) 
            {
                $new = $dir . "/" . $file;

                if ( is_file( $new ) )
                {
                    if ( !$onlyWithExtension || substr( $file,  -$extensionLength - 1 ) == ".$onlyWithExtension" )
                    {
                         $total[] = $new;
                    }
                }
                elseif( is_dir( $new ) )
                {
                    readDirRecursively( $new, $total, $onlyWithExtension );
                }
            }
        }
    }

   $directories = array();
   $regressionDir = dirname(__FILE__) . "/regression_tests";
   readDirRecursively( $regressionDir, $directories, "in" );


   foreach ( $directories as $directory )
   {
        $template = new ezcTemplate();
        $dir = dirname( $directory );
        $base = basename( $directory );

        $template->configuration = new ezcTemplateConfiguration( $dir, "/tmp/template_crap" );

        $template->configuration->addExtension( "TestBlocks" );
        $template->configuration->addExtension( "LinksCustomBlock" );
        $template->configuration->addExtension( "cblockTemplateExtension" );
        $template->configuration->addExtension( "Sha1CustomBlock" );


        if ( preg_match("#^(\w+)@(\w+)\..*$#", $base, $match ) )
        {
            $contextClass = "ezcTemplate". ucfirst( strtolower( $match[2] ) ) . "Context";
            $template->configuration->context = new $contextClass();
        }
        else
        {
            $template->configuration->context = new ezcTemplateNoContext();
        }

        $send = substr( $directory, 0, -3 ) . ".send";
        if ( file_exists( $send ) )
        {
            $template->send = include ($send);
        }

        $out = "";

        try
        {
            $out = $template->process( $base );
        }
        catch ( Exception $e )
        {
            $out = $e->getMessage();

            // Begin of the error message contains the full path. We replace this with 'mock' so that the
            // tests work on other systems as well.
            if ( strncmp( $out, $directory, strlen( $directory ) ) == 0 )
            {
                $out = "mock" . substr( $out, strlen( $directory ) );
            }
        }

        echo (".");
    }





?>
