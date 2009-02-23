<?php
/**
 * File containing the ezcPersistentObjectSchemaGenerator class
 *
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
                "o",        // short
                "overwrite",   // long
                ezcConsoleInput::TYPE_NONE,
                null,       // default
                false,      // multiple
                "Overwrite existing files.",
                "If this option is set, files will be overwriten if they alreday exist."
            )
        );

        $this->input->registerOption(
            new ezcConsoleOption(
                "p",        // short
                "prefix",   // long
                ezcConsoleInput::TYPE_STRING,
                null,       // default
                false,      // multiple
                "Class prefix.",
                "Unique prefix that will be prepended to all class names.",
                array(),    // dependencies
                array(),    // exclusions
                true,       // arguments
                false       // mandatory
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

        $this->input->argumentDefinition = new ezcConsoleArguments();

        $this->input->argumentDefinition[0] = new ezcConsoleArgument( "def dir" );
        $this->input->argumentDefinition[0]->shorthelp = "PersistentObject definition directory.";
        $this->input->argumentDefinition[0]->longhelp  = "Directory where PersistentObject definitions will be stored.";

        $this->input->argumentDefinition[1] = new ezcConsoleArgument( "class dir" );
        $this->input->argumentDefinition[1]->mandatory = false;
        $this->input->argumentDefinition[1]->shorthelp = "Class directory.";
        $this->input->argumentDefinition[1]->longhelp  = "Directory where PHP classes will be stored. Classes will not be generated if this argument is ommited.";
        
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
        catch ( ezcConsoleException $e )
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

        $defDir   = $this->input->argumentDefinition["def dir"]->value;
        $classDir = $this->input->argumentDefinition["class dir"]->value;

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
                    $this->raiseError( "Reader class not supported: '{$readerClass}'." );
                    break;
            }
        }
        catch ( Exception $e )
        {
            $this->raiseError( "Error reading schema: {$e->getMessage()}" );
        }

        try
        {
            $writer = new ezcDbSchemaPersistentWriter(
                $this->input->getOption( "overwrite" )->value,
                    $this->input->getOption( "prefix" )->value
            );
            $writer->saveToFile( $defDir, $schema );
            if ( $classDir !== null )
            {
                $writer = new ezcDbSchemaPersistentClassWriter(
                    $this->input->getOption( "overwrite" )->value,
                    $this->input->getOption( "prefix" )->value
                );
                $writer->saveToFile( $classDir, $schema );
            }
        }
        catch ( ezcBaseException $e )
        {
            $this->raiseError( "Error writing schema: {$e->getMessage()}" );
        }

        $this->output->outputLine( "PersistentObject definition successfully written to {$defDir}.", 'info' );
        if ( $classDir !== null )
        {
            $this->output->outputLine( "Class files successfully written to {$classDir}.", 'info' );
        }
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
