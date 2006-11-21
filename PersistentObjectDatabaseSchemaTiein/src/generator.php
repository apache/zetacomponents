<?php
/**
 * File containing the ezcPersistentObjectSchemaGenerator class
 *
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcPersistentObjectSchemaGenerator is capable to generate PersistentObject
 * definition files from DatabaseSchema definitions.
 *
 * This is the main class of the PersistentObjectDatabaseSchemaTiein package. It
 * implemets the generator class itself. To run the generator, please use the 
 * file "rungenerator.php", inside this package.
 *
 * To generate PersistentObject definitions from a DatabaseSchema, use the
 * following synopsis:
 *
 * <code>
 * $ php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s path/to/schema.file -f xml path/to/persistentobject/defs/
 * </code>
 *
 * The -s / --source parameter points to the source schema file. The -f / --format
 * option specifies the format the schema file has. The argument for the program 
 * specifies the directory, where the PersistentObject definitions will be stored.
 *
 * For help information simply call
 * <code>
 * $ php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php
 * </code>
 * or
 * <code>
 * $ php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -h
 * </code>
 * for extended help information.
 *
 * @package PersistentObjectDatabaseSchemaTiein
 */
class ezcPersistentObjectSchemaGenerator
{

    /**
     * The console input handler.
     * 
     * @var ezcConsoleInput
     */
    private $input;

    /**
     * The console output handler.
     * 
     * @var ezcConsoleOutput
     */
    private $output;


    const PROGRAM_DESCRIPTION = 'Generates defition files for the eZ PersistentObject package from eZ DatabaseSchema formats. The directory to save the definition files to is provided as an argument.';

    /**
     * Create a new generator.
     * This method initializes the necessary objects to run the application.
     * 
     * @return void
     */
    public function __construct()
    {
        $schemaFormats = implode( ", ", ezcDbSchemaHandlerManager::getSupportedFormats() );

        $this->output = new ezcConsoleOutput();

        $this->output->options->autobreak = 80;
        
        $this->output->formats->info->color = 'blue';
        $this->output->formats->info->style = array( 'bold' );

        $this->output->formats->help->color = 'blue';

        $this->output->formats->error->color = 'red';
        $this->output->formats->error->style = array( 'bold' );

        $this->output->formats->success->color = 'green';
        $this->output->formats->success->style = array( 'bold' );
        
        $this->input = new ezcConsoleInput();

        $this->input->registerOption(
            new ezcConsoleOption(
                "s",        // short
                "source",   // long
                ezcConsoleInput::TYPE_STRING,
                null,       // default
                false,      // multiple
                "DatabaseSchema source to use.",
                "The DatabaseSchema to use for the generation of the PersistentObject definition. Or the DSN to the database to grab the schema from.",
                array(),    // dependencies
                array(),    // exclusions
                true,       // arguments
                true        // mandatory
            )
        );

        $this->input->registerOption(
            new ezcConsoleOption(
                "f",        // short
                "format",   // long
                ezcConsoleInput::TYPE_STRING,
                null,       // default
                false,      // multiple
                "DatabaseSchema format of the input source.",
                "The format, the input DatabaseSchema is in. Valid formats are {$schemaFormats}.",
                array(),    // dependencies
                array(),    // exclusions
                true,       // arguments
                true        // mandatory
            )
        );

        $this->input->registerOption(
            new ezcConsoleOption(
                "e",        // short
                "empty",   // long
                ezcConsoleInput::TYPE_NONE,
                null,       // default
                false,      // multiple
                "Empty directory before writing.",
                "Delete all files from the destination directory before writing the definition files.",
                array(),    // dependencies
                array(),    // exclusions
                true,       // arguments
                false        // mandatory
            )
        );

        $this->input->registerOption(
            new ezcConsoleOption(
                "h",        // short
                "help",     // long
                ezcConsoleInput::TYPE_NONE,
                null,       // default
                false,      // multiple
                "Retrieve detailed help about this application.",
                "Print out this help information.",
                array(),    // dependencies
                array(),    // exclusions
                true,       // arguments
                false,      // mandatory
                true        // help option
            )
        );
        
        $this->output->outputLine( 'eZ components PersistentObject definition generator', 'info' );
        $this->output->outputLine();
    }

    /**
     * Run the generator.
     * Process the given options and generate a PersistentObject definition from it.
     * 
     * @return void
     */
    public function run()
    {
        try
        {
            $this->input->process();
        }
        catch ( ezcConsoleOptionException $e )
        {
            $this->raiseError( "Error while processing your options: {$e->getMessage()}", true );
        }

        if ( $this->input->getOption( 'h' )->value === true )
        {
            $this->output->outputText( 
                $this->input->getHelpText( 
                    ezcPersistentObjectSchemaGenerator::PROGRAM_DESCRIPTION,
                    80,
                    true
                ), 
                "help" 
            );
            exit( 0 );
        }

        if ( sizeof( ( $args =  $this->input->getArguments() ) ) < 1 )
        {
            $this->raiseError( "The directory to save the PersistentObject definitions to is required as an argument.", true );
        }

        $destination = $args[0];

        $schema = null;
        try
        {
            $readerClass = ezcDbSchemaHandlerManager::getReaderByFormat( $this->input->getOption( "format" )->value );
            $reader = new $readerClass();

            switch ( true )
            {
                case ( $reader instanceof ezcDbSchemaDbReader ):
                    $db = ezcDbFactory::create( $this->input->getOption( "source" )->value );
                    $schema = ezcDbSchema::createFromDb( $db );
                    break;
                case ( $reader instanceof ezcDbSchemaFileReader ):
                    $schema = ezcDbSchema::createFromFile( $this->input->getOption( "format" )->value, $this->input->getOption( "source" )->value );
                    break;
                default:
                    $this->raiseError( "Reader class not supported: <{$readerClass}>." );
                    break;
            }
        }
        catch ( ezcBaseException $e )
        {
            $this->raiseError( "Error reading schema: {$e->getMessage()}" );
        }

        if ( $this->input->getOption( "empty" )->value === true )
        {
            foreach ( glob( "$destination/*.php" ) as $file )
            {
                if ( unlink( $file ) === false )
                {
                    $this->raiseError( "Could not delete '$file'." );
                }
            }
        }

        try
        {
            $schema->writeToFile( 'persistent', $destination );
        }
        catch ( ezcBaseException $e )
        {
            $this->raiseError( "Error writing schema: {$e->getMessage()}" );
        }

        $this->output->outputLine( "PersistentObject definition successfully written to {$destination}.", 'info' );
    }

    /**
     * Prints the message of an occured error and exits the program.
     * This method is used to print an error message, as soon as an error
     * occurs end quit the program with return code -1. Optionally, the
     * method will trigger the help text to be printed after the error message.
     * 
     * @param string $message The error message to print
     * @param bool $printHelp Whether to print the help after the error msg.
     */
    private function raiseError( $message, $printHelp = false )
    {
        $this->output->outputLine( $message, 'error' );
        $this->output->outputLine();
        if ( $printHelp === true )
        {
            $this->output->outputText( 
                $this->input->getHelpText( 
                    ezcPersistentObjectSchemaGenerator::PROGRAM_DESCRIPTION
                ), 
                "help" 
            );
        }
        exit( -1 );
    }
}
?>
